<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Enum\DeliveryCompany;

readonly class Package extends BaseResponseDto
{
    /**
     * 配列プロパティの要素クラスを指定するマッピング。
     *
     * - ItemModelList     => Item[]
     * - ShippingModelList => Shipping[]
     */
    protected const array ARRAY_CHILD_MAP = [
        'ItemModelList'     => Item::class,
        'ShippingModelList' => Shipping::class,
    ];

    /**
     * @param int              $basketId                     バスケットID（パッケージ識別子）
     * @param int              $postagePrice                 送料金額
     * @param float            $postageTaxRate               送料に対する税率
     * @param int              $deliveryPrice                配送手数料
     * @param float            $deliveryTaxRate              配送手数料に対する税率
     * @param int              $goodsPrice                   商品金額（税抜合計）
     * @param int              $totalPrice                   パッケージ合計金額（税込）
     * @param string|null      $noshi                        のし設定（未設定時は null）
     * @param int              $packageDeleteFlag            パッケージ削除フラグ（0:有効 / 1:削除済）
     * @param Sender           $SenderModel                  発送元情報 DTO
     * @param Item[]           $ItemModelList                商品明細 DTO の配列
     * @param Shipping[]|null  $ShippingModelList            出荷情報 DTO の配列（出荷なしの場合は null）
     * @param DeliveryCVS|null $DeliveryCvsModel             コンビニ受取情報 DTO（通常配送などで未設定の場合は null）
     * @param DeliveryCompany  $defaultDeliveryCompanyCode   デフォルト配送会社 Enum
     * @param int              $dropOffFlag                  置き配フラグ（0/1）
     * @param string|null      $dropOffLocation              置き配場所（指定なしの場合は null）
     * @param SocialGift|null  $socialGift                   ソーシャルギフト情報 DTO（通常注文では null）
     */
    protected function __construct(
        public int $basketId,
        public int $postagePrice,
        public float $postageTaxRate,
        public int $deliveryPrice,
        public float $deliveryTaxRate,
        public int $goodsPrice,
        public int $totalPrice,
        public ?string $noshi,
        public int $packageDeleteFlag,
        public Sender $SenderModel,
        public array $ItemModelList,
        public ?array $ShippingModelList,
        public ?DeliveryCVS $DeliveryCvsModel,
        public DeliveryCompany $defaultDeliveryCompanyCode,
        public int $dropOffFlag,
        public ?string $dropOffLocation,
        public ?SocialGift $socialGift
    ) {}
}
