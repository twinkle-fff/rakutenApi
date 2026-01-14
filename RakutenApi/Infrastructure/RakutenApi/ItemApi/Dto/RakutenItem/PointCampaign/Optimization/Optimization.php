<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\PointCampaign\Optimization;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：ポイントキャンペーン最適化設定 DTO
 *
 * ポイントキャンペーンにおいて、
 * **顧客が獲得できるポイント倍率の上限を制御・最適化するための設定**
 * を表す。
 *
 * 本 DTO における "Optimization" は、
 * - 店舗側のコスト最適化
 * - 内部アルゴリズム
 * を意味するものではなく、
 * **顧客に付与されるポイントメリットの上限値**
 * を定義する概念である。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 複数キャンペーンが重複する場合でも、顧客が得られるポイント倍率の最大値を表す
 * - 未設定の場合を考慮し null を許容する
 *
 * 親 DTO（PointCampaign など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "maxPointRate": 20
 * }
 * ```
 * ※ 上記例は「キャンペーンが重なっても、顧客が得られるポイントは最大20倍まで」
 *    を意味する
 */
final readonly class Optimization extends BaseResponseDto
{
    /**
     * @param int|null $maxPointRate
     *  顧客が獲得できるポイント倍率の最大値
     *
     *  例:
     *  - null : 上限なし、または最適化設定なし
     *  - 10   : 最大10倍まで
     *  - 20   : 最大20倍まで
     */
    public function __construct(
        public ?int $maxPointRate
    ) {}
}
