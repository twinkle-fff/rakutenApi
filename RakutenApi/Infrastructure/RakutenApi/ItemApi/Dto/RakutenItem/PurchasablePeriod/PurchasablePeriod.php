<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\PurchasablePeriod;

use DateTime;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：購入可能期間 DTO
 *
 * 商品が購入可能な期間（開始日時・終了日時）を表す。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 購入可能開始日時と終了日時を {@see DateTime} として保持する
 * - 期間が未設定、または片側のみ指定されるケースを考慮し null を許容する
 *
 * 親 DTO（RakutenItem など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "start": "2025-01-01T00:00:00+09:00",
 *   "end": "2025-12-31T23:59:59+09:00"
 * }
 * ```
 */
final readonly class PurchasablePeriod extends BaseResponseDto
{
    /**
     * @param DateTime|null $start
     *  購入可能開始日時
     *
     * @param DateTime|null $end
     *  購入可能終了日時
     */
    public function __construct(
        public ?DateTime $start,
        public ?DateTime $end,
    ) {}
}
