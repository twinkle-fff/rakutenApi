<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\CustomizationOption\Selection;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：カスタマイズオプションの選択肢 DTO
 *
 * CustomizationOption に紐づく単一の選択肢を表す。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 親 DTO（CustomizationOption）の selections 配列要素として使用される
 * - 表示用の値のみを保持するシンプルな DTO
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "displayValue": "赤"
 * }
 * ```
 */
final readonly class Selection extends BaseResponseDto
{
    /**
     * @param string|null $displayValue
     *  選択肢の表示名（例：「赤」「Mサイズ」など）
     */
    public function __construct(
        public ?string $displayValue
    ) {}
}
