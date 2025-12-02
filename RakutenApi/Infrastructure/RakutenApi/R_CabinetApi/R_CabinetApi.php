<?php

namespace RakutenApi\Infrastructure\RakutenApi\R_CabinetApi;

require_once __DIR__ . "/../../../../vendor/autoload.php";

use Exception;
use HttpClient\App\Port\MultiPartClientPort;
use HttpClient\Infrastructure\Enum\RequestType;
use HttpClient\Infrastructure\MultipartClient;
use RakutenApi\Application\Port\RakutenApi\R_CabinetPort;
use RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Dto\GetFolder\Folder;
use RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Dto\GetFolder\FolderResponse;
use RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Dto\InsertImage\InsertImageParams;
use RakutenApi\Infrastructure\RakutenApi\Shared\Enum\ReturnType;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenAuth;

class R_CabinetApi implements R_CabinetPort
{
    private RakutenAuth $rakutenAuth;
    private RakutenApiClient $rakutenApiClient;
    private MultiPartClientPort $multiPartClient;

    private const string GET_FOLDER_ENDPOINT = "https://api.rms.rakuten.co.jp/es/1.0/cabinet/folders/get";

    private const string INSERT_IMAGE_ENDPOINT = "https://api.rms.rakuten.co.jp/es/1.0/cabinet/file/insert";
    private const int GET_FOLDER_DEFAULT_LIMIT = 100;


    public function __construct(
        ?RakutenAuth $rakutenAuth = null,
        ?MultiPartClientPort $multiPartClient = null,
    ) {
        $this->rakutenAuth = $rakutenAuth ?? new RakutenAuth();
        $this->rakutenApiClient = new RakutenApiClient($rakutenAuth);
        $this->multiPartClient = $multiPartClient ?? new MultipartClient();
    }

    /**
     * RMSキャビネットAPIからフォルダ一覧を「全件」取得する。
     *
     * 指定した件数ごとにページングしながら cabinet.folders.get を繰り返し呼び出し、
     * 最終的に全フォルダを 1 配列にまとめて返す。
     *
     * @param int|null $limit 1回のAPI呼び出しあたりの取得件数（省略時はデフォルト100件）
     * @return Folder[] 取得したフォルダ情報の配列
     *
     * @throws Exception APIレスポンスのパースに失敗した場合など
     */
    public function getFolders(?int $limit = null): array
    {
        $limit ??= self::GET_FOLDER_DEFAULT_LIMIT;
        $offset = 0;
        $readFolders = 0;

        while (true) {
            $result = [];

            $response = $this->getFolderSinglePage($offset, $limit);
            $readFolders += $response->folderCount;

            $result = array_merge($result, $response->folders);
            $offset++;
            if ($readFolders >= $response->folderAllCount) {
                break;
            }
        }

        return $result;
    }

    private function getFolderSinglePage(int $offset, ?int $limit = null): FolderResponse
    {

        $limit ??= self::GET_FOLDER_DEFAULT_LIMIT;
        $response = $this->rakutenApiClient->request(
            RequestType::GET,
            self::GET_FOLDER_ENDPOINT,
            [],
            [],
            ReturnType::TEXT
        );
        return FolderResponse::fromXMLResponse((string)$response);
    }
    public function insertImage(array|InsertImageParams $imagePrams, string $imagePath): bool
    {
        // 1. パラメータ正規化（array → InsertImageParams）
        if (is_array($imagePrams)) {
            $imagePrams = InsertImageParams::fromArray($imagePrams);
        }

        // 2. フォームフィールド（xml）を生成
        $fields = $this->normalizeInsertImageParam($imagePrams);

        // 3. マルチパートでPOST
        $response = $this->multiPartClient->post(
            self::INSERT_IMAGE_ENDPOINT,
            $fields,
            [$imagePath],            // アップロードするファイルのパス
            'file',                  // ファイルフィールド名（実装に合わせて変更）
            $this->insertImageHeader()
        );

        $body = (string)$response->body();
        // デバッグしたいならここで一度ログに出してOK
        // var_dump($body);

        // 4. レスポンスXMLをパース
        $xml = @simplexml_load_string($body);
        if ($xml === false) {
            throw new Exception("画像登録APIレスポンスの解析に失敗しました: {$body}");
        }

        $status        = $xml->status ?? null;
        $systemStatus  = $status?->systemStatus ? (string)$status->systemStatus : '';
        $message       = $status?->message      ? (string)$status->message      : '';

        // 5. systemStatus チェック
        if ($systemStatus !== 'OK') {
            throw new Exception("画像登録に失敗しました。systemStatus={$systemStatus}, message={$message}");
        }

        // 6. cabinetFileInsertResult の中身をチェック（成功時は resultCode=0）
        $result = $xml->cabinetFileInsertResult ?? null;
        $resultCode = $result?->resultCode ? (int)$result->resultCode : -1;

        if ($resultCode !== 0) {
            throw new Exception("画像登録に失敗しました。resultCode={$resultCode}");
        }

        return true;
    }

    /**
     * 画像登録リクエスト用 HTTP ヘッダを生成。
     * - Authorization: ESA Base64(serviceSecret:licenseKey)
     *
     * @return array<string,string>
     */
    private function insertImageHeader(): array
    {
        return [
            "Authorization: {$this->rakutenAuth->rakutenAuth()}",
            // Content-Type は curl が multipart/form-data; boundary=... を付与してくれる想定
            // 必要なら 'Content-Type' => 'multipart/form-data' を追加
        ];
    }

    /**
     * InsertImageParams から、multipart/form-data 用のフィールド配列を生成する。
     *
     * RMS 仕様では:
     *   - フィールド名 "xml" にリクエストXML文字列を入れる
     *   - フィールド名 "file" に画像ファイルを添付
     *
     * @param InsertImageParams $imagePrams
     * @return string
     */
    private function normalizeInsertImageParam(InsertImageParams $imagePrams): string
    {
        $xml = $imagePrams->toXML();

        // multipart/form-data の "xml" フィールドとして送る

        return $xml;
    }
}


if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    $rca = new R_CabinetApi();

    $imagePrams = new InsertImageParams(
        "sicas",
        "9978333",
        null,
        null
    );

    $rca->insertImage($imagePrams, "/Library/WebServer/Documents/library/rakutenApi/super_sale.jpg");

    // echo json_encode($rca->getFolders(),JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
}
