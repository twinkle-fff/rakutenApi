<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use Exception;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;
use ReflectionClass;

/**
 * 注文詳細における税計算結果のサマリーDTO
 */
readonly class TaxSummary extends BaseResponseDto
{
    /**
     * @param float $taxRate 税率（例：10.0）
     * @param int $reqPrice 税抜の請求金額
     * @param int $reqPriceTax 税額
     * @param int $totalPrice 税込金額（総額）
     * @param int $paymentCharge 決済手数料
     * @param int $couponPrice クーポン割引額
     * @param int $point 使用ポイント
     */
    protected function __construct(
        public float $taxRate,
        public int $reqPrice,
        public int $reqPriceTax,
        public int $totalPrice,
        public int $paymentCharge,
        public int $couponPrice,
        public int $point
    ) {}
}
