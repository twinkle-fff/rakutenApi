<?php
namespace RakutenApi\Application\Port\RakutenApi;

use Generator;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\ConfirmOrder\ComfirmOrderResponse;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\ConfirmOrder\ConfirmOrderResponse;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\NotifyShipment\OrderShipment;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail\OrderDetailResponse;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\SearchOrder\SearchOrderParams;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\SearchOrder\SearchOrderResponse;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;

/**
 * 楽天 RMS 受注API（Order API）に関するアプリケーション層のポート。
 *
 * このインターフェースは、インフラ層の Rakuten API クライアント実装に対する
 * 抽象化レイヤーであり、ユースケース層から利用される。
 *
 * 機能:
 * - 受注検索
 * - 受注詳細取得
 * - 注文確定処理（confirm）
 * - 出荷情報の登録（notifyShipment）
 */
interface OrderApiPort
{
    /**
     * 受注検索 API を実行する。
     *
     * @param array|SearchOrderParams $params
     *        - 配列または SearchOrderParams DTO
     *        - 配列の場合は SearchOrderParams::fromArray() と同じ構造
     *
     * @return SearchOrderResponse
     *        検索結果レスポンス DTO
     */
    public function searchOrder(array|SearchOrderParams $params): SearchOrderResponse;

    /**
     * 受注詳細 API を実行し、複数の注文番号の詳細情報を取得する。
     *
     * @param RakutenOrderNumber[] $orderNumberList
     *        楽天注文番号のリスト
     *
     * @param int|null $version
     *        API バージョン（未指定の場合は実装側のデフォルトを使用）
     *
     * @return Generator
     *        受注詳細レスポンス DTO
     */
    public function getOrderDetail(array $orderNumberList, ?int $version = null): Generator;

    /**
     * 受注確定処理（ConfirmOrder）を実行する。
     *
     * @param RakutenOrderNumber[] $orderNumberList
     *        確定対象の楽天注文番号リスト
     *
     * @return ComfirmOrderResponse
     *        確定に成功した注文番号リスト
     */
    public function comfirmOrder(array $orderNumberList): ComfirmOrderResponse;

    /**
     * 出荷情報登録（NotifyShipment）を実行する。
     *
     * @param OrderShipment $orderModelList
     *        1注文ごとの出荷モデル（OrderShipment DTO）
     *
     * @return bool
     *        API 成功時 true、失敗時 false
     */
    public function notifyShipment(OrderShipment $orderShipment): bool;

    // public function cancelOrder();
}
