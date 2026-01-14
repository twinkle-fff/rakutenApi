<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use DateTime;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Enum\DeliveryCompany;

/**
 * 楽天注文詳細API：配送情報 DTO
 *
 * 出荷情報（出荷明細ID、追跡番号、配送会社、配送会社名、出荷日）を表します。
 *
 * BaseResponseDto を継承しており、APIレスポンスの配列から
 * 自動的に型変換（int/string/DateTime/Enum）および必須チェックが行われます。
 *
 * 使用例：
 *     $shipping = Shipping::fromResponse($response['shipping']);
 */
readonly class Shipping extends BaseResponseDto
{
    /**
     * @param int               $shippingDetailId    出荷明細ID
     * @param int|null          $shippingNumber      追跡番号（未登録の場合は null）
     * @param DeliveryCompany   $deliveryCompany     配送会社 Enum（Yamato/Sagawa/etc）
     * @param string            $deliveryCompanyName 配送会社表示名（例：ヤマト運輸・佐川急便）
     * @param DateTime          $shippingDate        出荷日（DateTime 形式に自動変換）
     */
    protected function __construct(
        public ?int $shippingDetailId,
        public ?int $shippingNumber,
        public ?DeliveryCompany $deliveryCompany,
        public ?string $deliveryCompanyName,
        public ?DateTime $shippingDate
    ) {}
}
