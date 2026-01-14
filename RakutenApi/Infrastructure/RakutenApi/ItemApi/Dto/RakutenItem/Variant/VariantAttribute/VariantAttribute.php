<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\VariantAttribute;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：バリエーション属性 DTO
 *
 * 商品バリエーションに付与される属性情報を表す。
 *
 * 本 DTO は、
 * - 属性名
 * - 属性に対応する値（複数可）
 * - 単位情報
 * をまとめて保持し、
 * 商品バリエーションの補足的な属性表現を担う。
 *
 * 本 DTO が扱う属性は、
 * - SKU 識別用の主要バリエーション（カラー・サイズ等）
 * ではなく、
 * **仕様・特性・補足情報としての属性**
 * を想定している。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 各要素は未設定の場合を考慮し null を許容する
 * - 値の解釈・単位変換等のロジックは含まない
 *
 * 親 DTO（Variant など）から配列要素として参照される想定。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "name": "素材",
 *   "values": ["綿", "ポリエステル"],
 *   "unit": null
 * }
 * ```
 */
final readonly class VariantAttribute extends BaseResponseDto
{
    /**
     * @param string|null $name
     *  属性名
     *  （例：「素材」「原産国」「対応規格」など）
     *
     * @param string[]|null $values
     *  属性に対応する値の一覧
     *  （単一または複数の値を取り得る）
     *
     * @param int|null $unit
     *  属性値に対応する単位ID
     *  ※ 楽天側で管理される識別子
     */
    public function __construct(
        public ?string $name,
        public ?array $values,
        public ?int $unit
    ) {}
}
