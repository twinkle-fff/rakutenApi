<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\CustomizationOption;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\CustomizationOption\Selection\Selection;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\OptionInputType;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：カスタマイズオプション DTO
 *
 * 商品に付与可能なカスタマイズ項目（例：名入れ、色指定、サイズ指定など）を表す。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - selections は Selection DTO の配列として正規化される
 * - 値が存在しない場合は null を許容する設計
 *
 * ARRAY_CHILD_MAP により:
 *   - selections => Selection[] に自動変換される
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "displayName": "カラー",
 *   "inputType": "SELECT",
 *   "required": true,
 *   "selections": [
 *     { "name": "赤", "value": "red" },
 *     { "name": "青", "value": "blue" }
 *   ]
 * }
 * ```
 */
final readonly class CustomizationOption extends BaseResponseDto
{
    /**
     * 配列プロパティの要素型マップ。
     *
     * @var array<string, class-string<BaseResponseDto>>
     */
    protected const array ARRAY_CHILD_MAP = [
        'selections' => Selection::class,
    ];

    /**
     * @param string|null $displayName
     *  カスタマイズ項目の表示名（例：「カラー」「サイズ」）
     *
     * @param OptionInputType|null $inputType
     *  入力方式（SELECT / TEXT / NUMBER 等）
     *
     * @param bool|null $required
     *  必須入力かどうか
     *
     * @param Selection[]|null $selections
     *  選択肢一覧（SELECT 型の場合のみ存在する想定）
     */
    public function __construct(
        public ?string $displayName,
        public ?OptionInputType $inputType,
        public ?bool $required,
        public ?array $selections,
    ) {}
}
