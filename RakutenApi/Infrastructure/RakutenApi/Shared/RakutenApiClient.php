<?php

namespace RakutenApi\Infrastructure\RakutenApi\Shared;

use Exception;
use HttpClient\App\Port\HttpClientPort;
use HttpClient\App\Port\MultiPartClientPort;
use HttpClient\Infrastructure\HttpClient;
use HttpClient\Infrastructure\MultipartClient;
use HttpClient\Infrastructure\Enum\RequestType;
use HttpClient\Infrastructure\ValueObject\HttpParams;
use RakutenApi\Infrastructure\RakutenApi\Shared\Enum\ReturnType;
use RakutenApi\Infrastructure\RakutenApi\Shared\ValueObject\RakutenResponseStatus;

/**
 * 楽天市場 API 向けのクライアント。
 *
 * - RakutenAuth から認証ヘッダ（ESA トークン）を付与
 * - HttpClient 経由でリクエスト送信
 * - RakutenResponseStatus でステータス判定し、リトライ制御を行う
 */
class RakutenApiClient
{
    /** 最大リトライ回数 */
    private const int MAX_ATTEMPT = 10;

    /** バックオフの最大待機秒数 */
    private const int MAX_WAIT_TIME = 30;

    private RakutenAuth $auth;
    private HttpClientPort $httpClient;
    private MultiPartClientPort $multiPartClient;

    /**
     * @param RakutenAuth|null        $auth              認証情報プロバイダ（nullならデフォルト生成）
     * @param HttpClientPort|null     $httpClient        通常のHTTPクライアント
     * @param MultiPartClientPort|null $multiPartClient  マルチパート用HTTPクライアント
     */
    public function __construct(
        ?RakutenAuth $auth = null,
        ?HttpClientPort $httpClient = null,
        ?MultiPartClientPort $multiPartClient = null
    ) {
        $this->auth           = $auth ?? new RakutenAuth();
        $this->httpClient     = $httpClient ?? new HttpClient();
        $this->multiPartClient = $multiPartClient ?? new MultipartClient();
    }

    /**
     * 楽天市場 API へ JSON ベースのリクエストを行う.
     *
     * 成功時はレスポンスボディを配列として返却し、
     * 失敗時は例外をスローする（リトライポリシーは RakutenResponseStatus による）。
     *
     * @param string|RequestType      $requestType HTTPメソッド
     * @param string                  $uri         エンドポイントURL
     * @param array|HttpParams        $params      リクエストパラメータ
     * @param array<string,string>    $headers     追加ヘッダ
     *
     * @return array レスポンスJSONを配列化したもの
     *
     * @throws Exception リトライ不能 or 試行回数上限時
     */
    public function request(
        string|RequestType $requestType,
        string $uri,
        array|HttpParams $params,
        array $headers = [],
        string|ReturnType $returnType = ReturnType::JSON
    ): array|string {
        $attempt = 0;
        $returnType = $returnType instanceof ReturnType ? $returnType : ReturnType::tryFrom($returnType);
        while (true) {
            // 毎回最新の認証ヘッダを付与
            $headers['Authorization'] = $this->auth->rakutenAuth();

            $response = $this->httpClient->request(
                $requestType,
                $uri,
                $params,
                headers: $headers
            );

            $status = RakutenResponseStatus::fromStatusCode($response->code());
            
            if ($status->isSuccess()) {
                return match ($returnType){
                    ReturnType::JSON=>$response->json(),
                    ReturnType::TEXT=>$response->body(),
                    ReturnType::XML=>$response->body(),
                    default=>$response->body(),
                };
            }

            if (!$status->willRetry()) {
                throw new Exception(
                    "楽天市場APIの接続に失敗しました。"
                    . " code: {$response->code()}, response: {$response->body()}"
                );
            }

            if ($attempt >= self::MAX_ATTEMPT) {
                throw new Exception(
                    "楽天市場APIの接続に失敗しました。試行回数上限に達しました。"
                    . " code: {$response->code()}, response: {$response->body()}"
                );
            }

            $this->backOff($attempt);
            $attempt++;
        }
    }

    /**
     * 指数バックオフで待機する.
     *
     * 例: attempt=0 → 1秒, 1 → 2秒, 2 → 4秒 ... 最大 MAX_WAIT_TIME 秒.
     *
     * @param int $attempt これまでの試行回数
     */
    private function backOff(int $attempt): void
    {
        $waitTime = min(2 ** $attempt, self::MAX_WAIT_TIME);
        sleep($waitTime);
    }
}
