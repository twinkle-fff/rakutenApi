<?php

namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\NotifyShipment;

use InvalidArgumentException;

/**
 * 出荷通知用の「バスケット」DTO。
 *
 * - 1つの basketId に対して複数の Shipment をぶら下げる構造
 * - toArray() 時に楽天API仕様の
 *   - basketId
 *   - ShippingModelList
 *   というキー構造で出力する。
 */
readonly class ShippingBasket
{
    /**
     * バスケットID（楽天側の basketId）。
     */
    private string $basketId;

    /**
     * 出荷情報リスト。
     *
     * @var Shipment[]
     */
    private array $shipments;

    /**
     * コンストラクタ。
     *
     * @param string     $basketId  バスケットID
     * @param Shipment[] $shipments Shipment の配列
     *
     * @throws InvalidArgumentException Shipment 以外の要素が混ざっている場合
     */
    public function __construct(
        string $basketId,
        array $shipments
    ) {
        foreach ($shipments as $shipment) {
            if (!$shipment instanceof Shipment) {
                $type = is_object($shipment) ? get_class($shipment) : gettype($shipment);
                throw new InvalidArgumentException(
                    "ShippingBasket: shipments の要素が Shipment ではありません: {$type}"
                );
            }
        }

        $this->basketId  = $basketId;
        $this->shipments = $shipments;
    }

    /**
     * 楽天APIに渡すための配列形式に変換する。
     *
     * 出力イメージ:
     * [
     *   "basketId"         => "xxx",
     *   "ShippingModelList"=> [
     *       [ ...Shipment1... ],
     *       [ ...Shipment2... ],
     *   ],
     * ]
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'basketId'          => $this->basketId,
            'ShippingModelList' => array_map(
                static fn (Shipment $shipment) => $shipment->toArray(),
                $this->shipments
            ),
        ];
    }

    /**
     * 配列から ShippingBasket を生成する。
     *
     * 期待する入力フォーマット:
     * [
     *   "basketId"          => "xxx",
     *   "ShippingModelList" => [
     *       [ ...Shipment配列... ],
     *       ...
     *   ],
     * ]
     *
     * @param array $data
     * @return self
     *
     * @throws InvalidArgumentException 想定キーが無い / 型が不正な場合
     */
    public static function fromArray(array $data): self
    {
        if (!isset($data['basketId'])) {
            throw new InvalidArgumentException('ShippingBasket::fromArray: basketId が指定されていません。');
        }

        if (!isset($data['ShippingModelList']) || !is_array($data['ShippingModelList'])) {
            throw new InvalidArgumentException('ShippingBasket::fromArray: ShippingModelList が不正です。');
        }

        $shipments = array_map(
            static fn (array $row) => Shipment::fromArray($row),
            $data['ShippingModelList']
        );

        return new self(
            $data['basketId'],
            $shipments
        );
    }
}
