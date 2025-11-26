<?php
namespace RakutenApi\Application\Port\RakutenApi;

use RakutenApi\Application\Dto\ItemSearchParams;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenSearchItemResponse;
use Generator;

/**
 * ItemAPiPort
 *
 * 楽天 RMS「商品検索 API」のアプリケーション層用ポート。
 * 実装（Infrastructure）はこのインターフェイスに従うことで、
 * アプリケーション層から楽天API依存を隔離する。
 *
 * 現時点では全件ストリーミング取得のみ定義している。
 * 必要に応じて searchItems()（1ページ取得）などもここへ追加してよい。
 */
interface ItemAPiPort
{
    /**
     * 商品をストリーミング取得する。
     *
     * - 大量商品でもメモリ使用を抑える
     * - API の複数ページを内部でハンドリング
     * - 1商品ずつ逐次 yield する
     *
     * @param array|ItemSearchParams|null $params
     *        API 検索パラメータ（null の場合 defaultParams が適用される）
     *
     * @return Generator<array>
     *        各商品の連想配列を 1件ずつ yield するジェネレータ
     */
    public function streamAllItems(array|ItemSearchParams|null $params = null): Generator;
}
