<?php

namespace RakutenApi\Infrastructure\RakutenApi\R_CabinetApi;

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

/**
 * RMS R-Cabinet API の具象実装。
 *
 * このクラスは以下の機能を提供する:
 * - キャビネットフォルダ一覧の取得
 * - 画像ファイルのアップロード
 *
 * 認証情報の生成、HTTP通信、レスポンスDTOへの変換を内包し、
 * Application層からは {@see R_CabinetPort} 経由で利用されることを想定する。
 */
class R_CabinetApi implements R_CabinetPort
{
    /**
     * 楽天RMS API認証情報。
     */
    private RakutenAuth $rakutenAuth;

    /**
     * 楽天API共通クライアント。
     */
    private RakutenApiClient $rakutenApiClient;

    /**
     * multipart/form-data 用HTTPクライアント。
     */
    private MultiPartClientPort $multiPartClient;

    /**
     * フォルダ一覧取得APIエンドポイント。
     */
    private const string GET_FOLDER_ENDPOINT = "https://api.rms.rakuten.co.jp/es/1.0/cabinet/folders/get";

    /**
     * 画像登録APIエンドポイント。
     */
    private const string INSERT_IMAGE_ENDPOINT = "https://api.rms.rakuten.co.jp/es/1.0/cabinet/file/insert";

    /**
     * フォルダ一覧取得時のデフォルト件数。
     */
    private const int GET_FOLDER_DEFAULT_LIMIT = 100;

    /**
     * コンストラクタ。
     *
     * 引数を省略した場合は、標準実装を内部で自動生成する。
     *
     * @param RakutenAuth|null $rakutenAuth
     *  楽天API認証オブジェクト。
     *
     * @param MultiPartClientPort|null $multiPartClient
     *  multipart/form-data 送信用クライアント。
     */
    public function __construct(
        ?RakutenAuth $rakutenAuth = null,
        ?MultiPartClientPort $multiPartClient = null,
    ) {
        $this->rakutenAuth = $rakutenAuth ?? new RakutenAuth();
        $this->rakutenApiClient = new RakutenApiClient($this->rakutenAuth);
        $this->multiPartClient = $multiPartClient ?? new MultipartClient();
    }

    /**
     * RMSキャビネットAPIからフォルダ一覧を全件取得する。
     *
     * 指定件数ごとにページングしながら cabinet.folders.get を繰り返し呼び出し、
     * 最終的に全フォルダを1つの配列へまとめて返す。
     *
     * @param int|null $limit
     *  1回のAPI呼び出しで取得する件数。
     *  null の場合はデフォルト値 {@see self::GET_FOLDER_DEFAULT_LIMIT} を使用する。
     *
     * @return Folder[]
     *  取得したフォルダ情報DTOの配列
     *
     * @throws Exception
     *  APIレスポンスのパースに失敗した場合など
     */
    public function getFolders(?int $limit = null): array
    {
        $limit ??= self::GET_FOLDER_DEFAULT_LIMIT;
        $offset = 1;
        $readFolders = 0;
        $result = [];

        while (true) {
            $response = $this->getFolderSinglePage($offset, $limit);
            $readFolders += $response->folderCount;
            $result = array_merge($result, $response->folders);

            if ($readFolders >= $response->folderAllCount) {
                break;
            }

            $offset++;
        }

        return $result;
    }

    /**
     * RMSキャビネットAPIからフォルダ一覧を1ページ分取得する。
     *
     * @param int $offset
     *  取得ページ位置。
     *  RMS API仕様上の offset に相当する。
     *
     * @param int|null $limit
     *  1回のAPI呼び出しで取得する件数。
     *  null の場合はデフォルト値 {@see self::GET_FOLDER_DEFAULT_LIMIT} を使用する。
     *
     * @return FolderResponse
     *  1ページ分のフォルダ情報と総件数情報を保持するレスポンスDTO
     *
     * @throws Exception
     *  XMLレスポンスの解析に失敗した場合など
     */
    public function getFolderSinglePage(int $offset, ?int $limit = null): FolderResponse
    {
        $limit ??= self::GET_FOLDER_DEFAULT_LIMIT;

        $params = [
            "limit" => $limit,
        ];

        if ($offset !== false) {
            $params["offset"] = $offset;
        }

        $response = $this->rakutenApiClient->request(
            RequestType::GET,
            self::GET_FOLDER_ENDPOINT,
            $params,
            [],
            ReturnType::TEXT
        );

        return FolderResponse::fromXMLResponse((string)$response);
    }

    /**
     * RMSキャビネットへ画像をアップロードする。
     *
     * 処理の流れ:
     * 1. array が渡された場合は InsertImageParams へ正規化
     * 2. XMLフィールドを生成
     * 3. multipart/form-data でPOST
     * 4. XMLレスポンスを解析
     * 5. systemStatus および resultCode を検証
     * 6. 成功時は FileId を返却
     *
     * @param array|InsertImageParams $imagePrams
     *  画像アップロード用リクエストパラメータ
     *
     * @param string $imagePath
     *  アップロード対象画像のファイルパス
     *
     * @return string|bool
     *  成功時は FileId、取得できない場合は false
     *
     * @throws Exception
     *  レスポンスXMLの解析失敗時、またはAPI上の登録失敗時
     */
    public function insertImage(array|InsertImageParams $imagePrams, string $imagePath): string|bool
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
            [$imagePath],
            'file',
            $this->insertImageHeader()
        );

        $body = (string)$response->body();

        // 4. レスポンスXMLをパース
        $xml = @simplexml_load_string($body);
        $json = json_decode(json_encode($xml), true);

        if ($xml === false) {
            throw new Exception("画像登録APIレスポンスの解析に失敗しました: {$body}");
        }

        $status = $xml->status ?? null;
        $systemStatus = $status?->systemStatus ? (string)$status->systemStatus : '';
        $message = $status?->message ? (string)$status->message : '';

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

        return $json["cabinetFileInsertResult"]["FileId"] ?? false;
    }

    /**
     * 画像登録リクエスト用HTTPヘッダを生成する。
     *
     * Authorization ヘッダには、楽天RMS用の認証文字列を設定する。
     * Content-Type は multipart/form-data の boundary をHTTPクライアント側へ任せる想定。
     *
     * @return array<int,string>
     *  送信ヘッダ文字列の配列
     */
    private function insertImageHeader(): array
    {
        return [
            "Authorization: {$this->rakutenAuth->rakutenAuth()}",
        ];
    }

    /**
     * InsertImageParams から multipart/form-data 用の XML文字列を生成する。
     *
     * RMS仕様では:
     * - フィールド名 "xml" にリクエストXML文字列を設定
     * - フィールド名 "file" に画像ファイルを添付
     *
     * @param InsertImageParams $imagePrams
     *  画像登録リクエストDTO
     *
     * @return string
     *  XML文字列
     */
    private function normalizeInsertImageParam(InsertImageParams $imagePrams): string
    {
        return $imagePrams->toXML();
    }
}

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    $rca = new R_CabinetApi();

    // $imagePrams = new InsertImageParams(
    //     "sicas",
    //     "9978333",
    //     null,
    //     null
    // );

    // $rca->insertImage($imagePrams, "/Library/WebServer/Documents/library/rakutenApi/super_sale.jpg");

    echo json_encode($rca->getFolders(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
