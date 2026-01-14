<?php

namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\Shipping\PostageSegment;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：送料区分（国内／海外）DTO
 *
 * 商品バリエーションにおける送料設定を、
 * **配送先区分（国内・海外）ごと** に表す。
 *
 * 本 DTO は、
 * - 国内配送時の送料区分
 * - 海外配送時の送料区分
 * を数値IDとして保持する。
 *
 * 各値は楽天側で管理される送料区分IDであり、
 * 実際の送料金額や計算ロジックは含まない。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 対象区分が存在しないケースを考慮し null を許容する
 *
 * 親 DTO（Shipping / Variant など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "local": 1,
 *   "overseas": 3
 * }
 * ```
 */
final readonly class PostageSegment extends BaseResponseDto
{
    /**
     * @param int|null $local
     *  国内配送に適用される送料区分ID
     *
     * @param int|null $overseas
     *  海外配送に適用される送料区分ID
     */
    public function __construct(
        public ?int $local,
        public ?int $overseas
    ) {}
}
