<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use DateTime;
use Exception;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;
use ReflectionClass;

/**
 * 注文詳細におけるクーポン情報 DTO
 */
readonly class Coupen extends BaseResponseDto
{
    /**
     * @param string   $couponCode        クーポンコード
     * @param int      $itemId            商品ID
     * @param string   $couponName        クーポン名称
     * @param string   $couponSummary     クーポン概要
     * @param string   $couponCapital     クーポン発行元
     * @param int      $couponCapitalCode クーポン発行元コード
     * @param DateTime $expiryDate        クーポン有効期限
     * @param int      $couponPrice       クーポン割引額
     * @param int      $couponUnit        クーポン適用単位
     * @param int      $couponTotalPrice  クーポン総割引額
     * @param int      $itemDetailId      明細行ID
     */
    protected function __construct(
        public string $couponCode,
        public int $itemId,
        public string $couponName,
        public string $couponSummary,
        public string $couponCapital,
        public int $couponCapitalCode,
        public DateTime $expiryDate,
        public int $couponPrice,
        public int $couponUnit,
        public int $couponTotalPrice,
        public int $itemDetailId
    ) {}
}
