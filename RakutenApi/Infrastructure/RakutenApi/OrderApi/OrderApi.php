<?php

namespace RakutenApi\Infrastructure\RakutenApi\OrderApi;

use Generator;
use RakutenApi\Application\Port\RakutenApi\OrderApiPort;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\ConfirmOrder\ComfirmOrderResponse;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\NotifyShipment\OrderShipment;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail\Order;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\SearchOrder\SearchOrderParams;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\SearchOrder\SearchOrderResponse;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;
/**
 * 楽天注文API統合クラス。
 *
 * Search / GetDetail / Confirm / Shipment などの
 * 「注文」に関する API エンドポイントを一括管理する。
 *
 * ユースケース実装クラスをまとめて提供し、
 * アプリケーションからは OrderApiPort を通して利用する。
 */
class OrderApi implements OrderApiPort
{
    private RakutenApiClient $client;

    private SearchOrder $searchOrder;
    private GetOrderDetail $getOrderDetail;
    private ComfirmOrder $comfirmOrder;
    private NotifyShippment $notifyShipment;

    /**
     * コンストラクタ
     *
     * @param RakutenApiClient|null $client 既存クライアントを流用したい場合に使用
     */
    public function __construct(?RakutenApiClient $client = null)
    {
        $this->client = $client ?? new RakutenApiClient();

        // 各ユースケースに DI 注入
        $this->searchOrder     = new SearchOrder($this->client);
        $this->getOrderDetail  = new GetOrderDetail($this->client);
        $this->comfirmOrder    = new ComfirmOrder($this->client);        // ← typo 修正
        $this->notifyShipment  = new NotifyShippment($this->client);     // ← typo 修正
    }

    /**
     * 注文検索API（searchOrder）
     *
     * @param array|SearchOrderParams $params
     * @return SearchOrderResponse
     */
    public function searchOrder(array|SearchOrderParams $params): SearchOrderResponse
    {
        return $this->searchOrder->execute($params);
    }

    /**
     * 注文詳細API（getOrderDetail）
     *
     * @param array<RakutenOrderNumber> $orderNumberList
     * @param int|null $version
     * @return Generator<Order>
     */
    public function getOrderDetail(array $orderNumberList, ?int $version = null): Generator
    {
        return $this->getOrderDetail->execute($orderNumberList, $version);
    }

    /**
     * 注文確定API（confirmOrder）
     *
     * @param RakutenOrderNumber[] $orderNumberList
     * @return ComfirmOrderResponse
     */
    public function comfirmOrder(array $orderNumberList): ComfirmOrderResponse
    {
        return $this->comfirmOrder->execute($orderNumberList);
    }

    /**
     * 発送報告API（notifyShipment）
     *

     * @param OrderShipment $orderShipment
     * @return bool
     */
    public function notifyShipment(OrderShipment $orderShipment): bool
    {
        return $this->notifyShipment->execute($orderShipment);
    }
}
