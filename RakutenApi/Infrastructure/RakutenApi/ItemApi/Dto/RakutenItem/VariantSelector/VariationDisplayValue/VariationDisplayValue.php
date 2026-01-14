<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\VariantSelector\VariationDisplayValue;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：バリエーション表示値 DTO
 *
 * 商品バリエーション選択（Variant Selector）において、
 * ユーザーに表示されるバリエーションの表示値を表す。
 *
 * 本 DTO は、
 * - 内部的な識別子やコード値ではなく
 * - **画面上に表示される文言（ラベル）**
 * を保持することを目的とする。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 値が存在しないケースを考慮し null を許容する
 *
 * 親 DTO（VariantSelector / Variation など）から
 * ネストされた子要素として参照される想定。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "displayValue": "レッド"
 * }
 * ```
 */
final readonly class VariationDisplayValue extends BaseResponseDto
{
    /**
     * @param string|null $displayValue
     *  バリエーション選択肢として表示される文言
     *  （例：「レッド」「Mサイズ」「64GB」など）
     */
    public function __construct(
        public ?string $displayValue
    ) {}
}
