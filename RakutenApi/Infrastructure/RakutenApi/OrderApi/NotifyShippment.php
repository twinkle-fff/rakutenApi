<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi;

use Exception;
use HttpClient\Infrastructure\Enum\RequestType;
use HttpClient\Infrastructure\ValueObject\HttpParams;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\NotifyShipment\OrderShipment;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

/**
 * 楽天RMS「注文発送報告API（updateOrderShipping）」を呼び出すユースケースクラス。
 *
 * - 注文ごとの発送情報（送り状番号・配送会社など）を OrderShipment DTO で受け取り、
 *   HTTP リクエストボディに変換して楽天APIに送信する。
 * - レスポンスの messageType をチェックし、INFO の場合のみ成功とみなす。
 */
class NotifyShippment
{
    /**
     * @var RakutenApiClient 楽天APIクライアント
     */
    private RakutenApiClient $client;

    /**
     * 発送報告APIのエンドポイントURL。
     */
    private const string UPDATE_SHIPMENT_ENDPOINT = 'https://api.rms.rakuten.co.jp/es/2.0/order/updateOrderShipping/';

    /**
     * コンストラクタ。
     *
     * @param RakutenApiClient|null $client 注入する楽天APIクライアント。
     *                                      null の場合は内部で新規インスタンスを生成する。
     */
    public function __construct(?RakutenApiClient $client = null)
    {
        $this->client = $client ?? new RakutenApiClient();
    }

    /**
     * 楽天RMSに対して発送報告（updateOrderShipping）を実行する。
     *
     * @param OrderShipment $orderShipment 発送報告対象の注文情報モデル。
     * @return bool                        true: API側が正常（messageType=INFO）と判断した場合
     *
     * @throws Exception APIレスポンスがエラー（messageType≠INFO）の場合
     */
    public function execute(OrderShipment $orderShipment): bool
    {
        $httpParams = $this->buildHttpBody($orderShipment);

        $response = $this->client->request(
            RequestType::POST,
            self::UPDATE_SHIPMENT_ENDPOINT,
            $httpParams,
        );

        return $this->handleResponse($response);
    }

    /**
     * 発送報告API向けのHTTPボディ（HttpParams）を組み立てる。
     *
     * OrderShipment DTO から配列形式に変換し、
     * HttpParams（HTTPクライアント側のValueObject）にラップする。
     *
     * @param OrderShipment $orderShipment 発送報告対象の注文情報モデル
     * @return HttpParams                  HTTPリクエストボディとして利用するパラメータオブジェクト
     */
    private function buildHttpBody(OrderShipment $orderShipment): HttpParams
    {
        $normalizedBody = $orderShipment->toArray();

        return HttpParams::fromArray($normalizedBody);
    }

    /**
     * 楽天APIからのレスポンスを判定する。
     *
     * - messageType が "INFO" の場合のみ成功（true）を返す。
     * - それ以外（"ERROR" など）の場合は例外をスローする。
     *
     * @param array<string,mixed> $response 楽天APIからのレスポンス配列
     * @return bool                         成功時 true
     *
     * @throws Exception エラーレスポンスだった場合
     */
    private function handleResponse(array $response): bool
    {
        return ($response['messageType'] ?? null) === 'INFO'
            ? true
            : throw new Exception(
                '楽天商品発送報告に失敗しました。detail:' . ($response['message'] ?? '不明なエラー')
            );
    }
}
