<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Payment;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：支払・税設定 DTO
 *
 * 商品価格に関する税計算および支払条件の設定を表す。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 税込み価格かどうか、適用税率、代引き手数料の価格内包有無を保持する
 * - 金額計算ロジックは持たず、設定値の保持に専念する
 *
 * 親 DTO（RakutenItem など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "taxIncluded": true,
 *   "taxRate": "10",
 *   "cashOnDeliveryFeeIncluded": false
 * }
 * ```
 */
final readonly class Payment extends BaseResponseDto
{
    /**
     * @param bool $taxIncluded
     *  商品価格が税込みかどうか
     *
     * @param string $taxRate
     *  適用される税率（例："10" / "8"）
     *  ※ API仕様上 string として返却されるため、数値変換は行わない
     *
     * @param bool $cashOnDeliveryFeeIncluded
     *  代引き手数料が商品価格に含まれているかどうか
     */
    public function __construct(
        public bool $taxIncluded,
        public ?string $taxRate,
        public bool $cashOnDeliveryFeeIncluded
    ) {}
}
