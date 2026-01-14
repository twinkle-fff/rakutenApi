<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\PointCampaign;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\PointCampaign\ApplicablePeriod\ApplicablePeriod;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\PointCampaign\Benefits\Benefits;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\PointCampaign\Optimization\Optimization;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：ポイントキャンペーン DTO
 *
 * 商品に適用されるポイントキャンペーン全体を表す集約 DTO。
 *
 * 本 DTO は、
 * - 「いつポイントが適用されるか」
 * - 「顧客がどれだけ得をするか」
 * - 「その得がどこまで許容されるか」
 * という **顧客視点の3要素** をまとめて表現する。
 *
 * 構成要素:
 * - {@see ApplicablePeriod} : ポイントキャンペーンの適用期間
 * - {@see Benefits}         : 顧客が得られるポイント倍率（メリット）
 * - {@see Optimization}     : 顧客メリットの上限最適化設定
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 各要素は存在しないケースを考慮し null を許容する
 * - 金額換算・付与ポイント計算等のロジックは含まない
 *
 * 親 DTO（RakutenItem など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "applicablePeriod": {
 *     "start": "2025-03-01T00:00:00+09:00",
 *     "end": "2025-03-31T23:59:59+09:00"
 *   },
 *   "benefits": {
 *     "pointRate": 10
 *   },
 *   "optimization": {
 *     "maxPointRate": 20
 *   }
 * }
 * ```
 */
readonly class PointCampaign extends BaseResponseDto
{
    /**
     * @param ApplicablePeriod|null $applicablePeriod
     *  ポイントキャンペーンの適用期間
     *
     * @param Benefits|null $benefits
     *  顧客が得られるポイント倍率（キャンペーン特典）
     *
     * @param Optimization|null $optimization
     *  顧客メリットの上限最適化設定
     */
    public function __construct(
        public ?ApplicablePeriod $applicablePeriod,
        public ?Benefits $benefits,
        public ?Optimization $optimization
    ) {}
}
