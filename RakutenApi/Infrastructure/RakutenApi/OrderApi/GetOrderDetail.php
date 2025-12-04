<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi;

use Exception;
use Generator;
use HttpClient\Infrastructure\Enum\RequestType;
use HttpClient\Infrastructure\ValueObject\HttpParams;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail\Order;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\OrderDetail\OrderDetailResponse;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

/**
 * 楽天RMS「注文詳細取得API（getOrder）」を叩くユースケースクラス。
 *
 * - 注文番号リストを受け取る
 * - バージョン番号を設定して POST リクエストを送信
 * - OrderModelList の各要素を Order DTO として Generator で返す
 *
 * 大量件数でもメモリ効率よく処理できるように
 * `yield` を使用して遅延評価する設計。
 *
 * エンドポイント:
 *   https://api.rms.rakuten.co.jp/es/2.0/order/getOrder/
 */
class GetOrderDetail
{
    /**
     * @var RakutenApiClient 楽天APIクライアント
     */
    private RakutenApiClient $client;

    /**
     * 注文詳細取得APIのエンドポイント
     */
    private const string GET_ORDER_ENDPOINT =
        "https://api.rms.rakuten.co.jp/es/2.0/order/getOrder/";

    /**
     * API version デフォルト値（現在最新）
     */
    private const int DEFAULT_API_VERSION = 9;

    /**
     * コンストラクタ。
     *
     * @param RakutenApiClient|null $client
     *     注入されたクライアント。null の場合は新規生成。
     */
    public function __construct(?RakutenApiClient $client = null)
    {
        $this->client = $client ?? new RakutenApiClient();
    }

    /**
     * 注文詳細取得APIを実行する。
     *
     * @param RakutenOrderNumber[] $orderNumberList
     *      取得対象の楽天注文番号リスト
     *
     * @param int|null $version
     *      APIバージョン（指定がなければ DEFAULT_API_VERSION）
     *
     * @return Generator|Order[]
     *      各注文を Order DTO として逐次返す Generator
     *
     * @throws Exception
     *      APIレスポンスが不正な場合
     */
    public function execute(array $orderNumberList, ?int $version = null): Generator
    {
        $version ??= self::DEFAULT_API_VERSION;

        $params = $this->buildHttpBody($orderNumberList, $version);

        $response = $this->client->request(
            RequestType::POST,
            self::GET_ORDER_ENDPOINT,
            $params
        );

        if (!isset($response["OrderModelList"])) {
            $mes = json_encode($$response, JSON_UNESCAPED_UNICODE); // ← 元コードの誤字のまま
            throw new Exception("注文詳細検索でエラーレスポンスが発生しました。detail:{$mes}");
        }

        foreach ($response["OrderModelList"] as $orderData) {
            yield Order::fromResponse($orderData);
        }
    }

    /**
     * API が要求する HTTP Body を構築する。
     *
     * "orderNumberList" は
     *   [ "123456-20241210-0000001234", ... ]
     * の形式である必要があるため
     * ValueObject → string に正規化する。
     *
     * @param RakutenOrderNumber[] $orderNumberList
     * @param int $version
     * @return HttpParams
     */
    public function buildHttpBody(array $orderNumberList, int $version): HttpParams
    {
        $array = [
            "orderNumberList" => array_map(
                fn(RakutenOrderNumber $n) => ($n->getValue()),
                $orderNumberList
            ),
            "version" => $version
        ];

        return HttpParams::fromArray($array);
    }
}
