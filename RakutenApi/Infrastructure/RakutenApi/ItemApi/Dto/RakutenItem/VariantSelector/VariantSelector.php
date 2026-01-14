<?php

namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\VariantSelector;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\VariantSelector\VariationDisplayValue\VariationDisplayValue;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：バリエーション選択項目 DTO
 *
 * 商品のバリエーション選択（例：カラー、サイズ、容量など）を表す。
 *
 * 本 DTO は、
 * - バリエーションの識別キー
 * - 画面表示用の項目名
 * - 選択可能な表示値一覧
 * をまとめて管理する。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 表示値は {@see VariationDisplayValue} の配列として正規化される
 * - バリエーションが存在しない商品を考慮し、各要素は null を許容する
 *
 * ARRAY_CHILD_MAP により:
 * - values 配列の各要素は {@see VariationDisplayValue} DTO に自動変換される
 *
 * 親 DTO（RakutenItem など）から配列要素として参照される想定。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "key": "color",
 *   "displayName": "カラー",
 *   "values": [
 *     { "displayValue": "レッド" },
 *     { "displayValue": "ブルー" }
 *   ]
 * }
 * ```
 */
final readonly class VariantSelector extends BaseResponseDto
{
    /**
     * 配列プロパティの要素型マップ。
     *
     * values 配列の各要素を {@see VariationDisplayValue} として扱う。
     *
     * @var array<string, class-string<BaseResponseDto>>
     */
    protected const array ARRAY_CHILD_MAP = [
        'values' => VariationDisplayValue::class,
    ];

    /**
     * @param string|null $key
     *  バリエーションの識別キー（例："color", "size"）
     *
     * @param string|null $displayName
     *  画面上に表示されるバリエーション項目名
     *
     * @param VariationDisplayValue[]|null $values
     *  選択可能なバリエーション表示値の一覧
     */
    public function __construct(
        public ?string $key,
        public ?string $displayName,
        public ?array $values,
    ) {}
}
