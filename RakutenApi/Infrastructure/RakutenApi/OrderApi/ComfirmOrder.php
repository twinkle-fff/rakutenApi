<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi;

use Exception;
use HttpClient\Infrastructure\Enum\RequestType;
use HttpClient\Infrastructure\ValueObject\HttpParams;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\ConfirmOrder\ComfirmOrderResponse;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

/**
 * 楽天RMS「注文確定API（confirmOrder）」を実行するユースケースクラス。
 *
 * - 注文番号（RakutenOrderNumber）配列を受け取り
 * - APIフォーマットに正規化して POST リクエストを送信
 * - ComfirmOrderResponse DTO に変換して返却
 *
 * エンドポイント:
 *   https://api.rms.rakuten.co.jp/es/2.0/order/confirmOrder/
 */
class ComfirmOrder
{
    /**
     * @var RakutenApiClient 楽天APIクライアント
     */
    private RakutenApiClient $client;

    /**
     * 注文確定APIのエンドポイントURL
     */
    private const string COMFIRM_ORDER_ENDPINT =
        "https://api.rms.rakuten.co.jp/es/2.0/order/confirmOrder/";

    /**
     * コンストラクタ。
     *
     * @param RakutenApiClient|null $client
     *      注入されたクライアントを利用する。
     *      null の場合は内部で新規インスタンスを生成する。
     */
    public function __construct(?RakutenApiClient $client)
    {
        $this->client = $client ?? new RakutenApiClient();
    }

    /**
     * 注文確定APIを実行する。
     *
     * @param RakutenOrderNumber[] $orderNumberList
     *      確定したい注文番号のリスト
     *
     * @return ComfirmOrderResponse
     *      APIレスポンスをDTOとして返却
     *
     * @throws Exception
     *      API通信エラーまたはレスポンス形式エラー
     */
    public function execute(array $orderNumberList): ComfirmOrderResponse
    {
        $normalizedParam = $this->buildHttpBody($orderNumberList);

        $response = $this->client->request(
            RequestType::POST,
            self::COMFIRM_ORDER_ENDPINT,
            $normalizedParam
        );

        return ComfirmOrderResponse::fromResponse($response);
    }

    /**
     * API要求形式の HTTP ボディ（HttpParams）を構築する。
     *
     * 楽天APIは orderNumberList の値として
     *   ["xxxxx-xxxxxxxx-xxxxxxxxxx", ...]
     * の形式を要求するため RakutenOrderNumber → string に正規化する。
     *
     * @param RakutenOrderNumber[] $orderNumberList
     * @return HttpParams
     */
    private function buildHttpBody(array $orderNumberList): HttpParams
    {
        $rawParam = [
            "orderNumberList" => array_map(
                fn(RakutenOrderNumber $n) => $n->getValue(),
                $orderNumberList
            )
        ];

        return HttpParams::fromArray($rawParam);
    }
}
