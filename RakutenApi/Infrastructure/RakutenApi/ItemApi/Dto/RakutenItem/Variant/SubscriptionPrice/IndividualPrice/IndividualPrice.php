<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\SubscriptionPrice\IndividualPrice;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：定期購入 個別価格 DTO
 *
 * 商品バリエーションの定期購入価格において、
 * **特定回（主に初回）に適用される個別価格**
 * を表す。
 *
 * 本 DTO が表す価格は、
 * - 通常販売価格
 * - 定期購入の標準価格
 * ではなく、
 * **キャンペーン等により初回のみ異なる価格が設定されるケース**
 * を想定した表示・参照用の価格情報である。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 金額計算・割引計算は行わず、表示用の価格値を保持する
 * - 未設定の場合を考慮し null を許容する
 *
 * 親 DTO（SubscriptionPrice など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "firstPrice": "980"
 * }
 * ```
 */
final readonly class IndividualPrice extends BaseResponseDto
{
    /**
     * @param string|null $firstPrice
     *  定期購入における初回購入時の価格
     *  ※ API仕様上 string として返却されるため数値変換は行わない
     */
    public function __construct(
        public ?string $firstPrice
    ) {}
}
