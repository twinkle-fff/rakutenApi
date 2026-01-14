<?php

namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\PointCampaign\Benefits;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：ポイントキャンペーン特典（顧客メリット）DTO
 *
 * ポイントキャンペーンにおいて、
 * 「購入者（顧客）がどれだけ得をするか」を表す特典情報を保持する。
 *
 * 本 DTO における "Benefit" は、
 * - 店舗側の負担
 * - システム設定
 * ではなく、
 * **顧客視点でのポイント還元メリット**
 * を意味する。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - ポイント付与率（変倍率）を整数値として保持する
 * - 金額換算や付与ポイント計算は行わず、値の保持に専念する
 *
 * 親 DTO（PointCampaign など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "pointRate": 10
 * }
 * ```
 * ※ 上記例は「通常ポイントに加えて 10 倍付与」を意味する
 */
final readonly class Benefits extends BaseResponseDto
{
    /**
     * @param int $pointRate
     *  ポイント変倍率（顧客が得られるポイント倍率）
     *
     *  例:
     *  - 1  : 通常ポイント
     *  - 5  : ポイント5倍
     *  - 10 : ポイント10倍
     */
    public function __construct(
        public int $pointRate
    ) {}
}
