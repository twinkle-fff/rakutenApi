<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\PointCampaign\ApplicablePeriod;

use DateTime;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：ポイントキャンペーン適用期間 DTO
 *
 * 商品に適用されるポイントキャンペーンの有効期間を表す。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - ポイント付与キャンペーンが有効となる開始日時・終了日時を保持する
 * - 期間が未設定、または片側のみ指定されるケースを考慮し null を許容する
 *
 * 親 DTO（PointCampaign など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "start": "2025-03-01T00:00:00+09:00",
 *   "end": "2025-03-31T23:59:59+09:00"
 * }
 * ```
 */
final readonly class ApplicablePeriod extends BaseResponseDto
{
    /**
     * @param DateTime|null $start
     *  ポイントキャンペーン適用開始日時
     *
     * @param DateTime|null $end
     *  ポイントキャンペーン適用終了日時
     */
    public function __construct(
        public ?DateTime $start,
        public ?DateTime $end
    ) {}
}
