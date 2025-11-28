<?php

namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\NotifyShipment;

use InvalidArgumentException;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;

/**
 * 楽天「出荷情報登録（NotifyShipment）」の
 * 1件分の注文出荷情報を表すDTO。
 *
 * - orderNumber           : 楽天注文番号
 * - BasketidModelList     : 出荷バスケットの配列（BasketidModel）
 *
 * 出力フォーマット（toArray）イメージ:
 * [
 *   'orderNumber'       => '341680-22222222-1241583267',
 *   'BasketidModelList' => [
 *       [ ...ShippingBasket1... ],
 *       [ ...ShippingBasket2... ],
 *   ],
 * ]
 */
readonly class OrderShipment
{
    /**
     * @var RakutenOrderNumber 注文番号
     */
    private RakutenOrderNumber $orderNumber;

    /**
     * @var ShippingBasket[] バスケットモデルの配列
     */
    private array $basketIdModelList;

    /**
     * コンストラクタ。
     *
     * @param RakutenOrderNumber $orderNumber       楽天注文番号
     * @param ShippingBasket[]   $basketIdModelList BasketidModel の配列
     *
     * @throws InvalidArgumentException ShippingBasket 以外の要素が混ざっている場合
     */
    public function __construct(
        RakutenOrderNumber $orderNumber,
        array $basketIdModelList
    ) {
        foreach ($basketIdModelList as $basket) {
            if (!$basket instanceof ShippingBasket) {
                $type = is_object($basket) ? get_class($basket) : gettype($basket);
                throw new InvalidArgumentException(
                    "OrderShipment: basketIdModelList の要素が ShippingBasket ではありません: {$type}"
                );
            }
        }

        $this->orderNumber       = $orderNumber;
        $this->basketIdModelList = $basketIdModelList;
    }

    /**
     * 楽天APIに渡すための配列形式に変換する。
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'orderNumber'       => $this->orderNumber->getValue(),
            'BasketidModelList' => array_map(
                static fn (ShippingBasket $basket) => $basket->toArray(),
                $this->basketIdModelList
            ),
        ];
    }

    /**
     * 配列から OrderShipment を生成する。
     *
     * 期待する入力フォーマット:
     * [
     *   'orderNumber'       => '341680-22222222-1241583267',
     *   'BasketidModelList' => [
     *       [ ...ShippingBasket 配列... ],
     *       ...
     *   ],
     * ]
     *
     * @param array $data
     * @return self
     *
     * @throws InvalidArgumentException 必須キー不足 / 型不正など
     */
    public static function fromArray(array $data): self
    {
        if (!isset($data['orderNumber']) || !is_string($data['orderNumber'])) {
            throw new InvalidArgumentException('OrderShipment::fromArray: orderNumber が不正です。');
        }

        if (!isset($data['BasketidModelList']) || !is_array($data['BasketidModelList'])) {
            throw new InvalidArgumentException('OrderShipment::fromArray: BasketidModelList が不正です。');
        }

        $orderNumber = new RakutenOrderNumber($data['orderNumber']);

        $baskets = array_map(
            static fn (array $row) => ShippingBasket::fromArray($row),
            $data['BasketidModelList']
        );

        return new self($orderNumber, $baskets);
    }
}
