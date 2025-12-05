<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi;

use Generator;

use RakutenApi\Application\Port\RakutenApi\ItemAPiPort;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\ItemSearchParams;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenSearchItemResponse;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

/**
 * 楽天 RMS「商品検索 API」実装クラス。
 *
 * - ポート(ItemAPiPort)の実装としてアプリケーション層に提供される。
 * - ページング処理を内部で持ち、streaming により全件を低メモリで返す。
 */
class ItemApi implements ItemAPiPort
{
    private RakutenApiClient $client;

    /** @var string 検索 API のエンドポイント */
    private const ITEM_API_ENDPOINT = "https://api.rms.rakuten.co.jp/es/2.0/items/search";

    /**
     * @param RakutenApiClient|null $rakutenApiClient
     *        差し替え可能な HTTP クライアント
     */
    public function __construct(?RakutenApiClient $rakutenApiClient = null)
    {
        $this->client = $rakutenApiClient ?? new RakutenApiClient();
    }

    /**
     * 商品をストリーミングで全件取得する。
     *
     * - 楽天APIのページングを内部で処理
     * - メモリを消費せず1商品ずつ yield する
     *
     * @param array|ItemSearchParams|null $params
     * @return Generator<array>
     */
    public function streamAllItems(array|ItemSearchParams|null $params = null): Generator
    {
        // パラメータ正規化
        $params ??= $this->defaultParams();
        $normalizedParams = ($params instanceof ItemSearchParams)
            ? $params
            : ItemSearchParams::fromArray($params);

        // 初期オフセット
        $offset = $normalizedParams->offset ?? 0;

        while (true) {
            $response = $this->searchItems($normalizedParams);

            // 1件ずつ返す
            foreach ($response->results as $result) {
                yield $result;
            }

            // 次ページ判定
            $offset += $normalizedParams->hits;

            if ($offset >= $response->numFound) {
                break;
            }

            // 次ページへ
            $normalizedParams->setOffset($offset);
        }
    }

    /**
     * 楽天 API から1ページ分の結果を取得する内部メソッド。
     *
     * @param ItemSearchParams $params
     * @return RakutenSearchItemResponse
     */
    private function searchItems(ItemSearchParams $params): RakutenSearchItemResponse
    {
        $normalizedParams = $params->toArray();
        $response = $this->client->request(
            "get",
            self::ITEM_API_ENDPOINT,
            $normalizedParams
        );

        return RakutenSearchItemResponse::fromResponse($response);
    }

    /**
     * デフォルトの検索パラメータ生成。
     *
     * @return ItemSearchParams
     */
    private function defaultParams(): ItemSearchParams
    {
        $params = ItemSearchParams::empty();
        $params->setHits(100);
        $params->setSortKey("created");
        $params->setIsInventoryIncluded(true);
        return $params;
    }
}
