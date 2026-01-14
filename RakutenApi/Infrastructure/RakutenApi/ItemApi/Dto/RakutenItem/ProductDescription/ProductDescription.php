<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：商品説明文 DTO
 *
 * 商品の説明文をデバイス別に保持する DTO。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - PC 表示用・スマートフォン表示用の説明文を分離して管理する
 * - どちらか一方、または両方が存在しないケースを考慮し null を許容する
 *
 * 親 DTO（RakutenItem）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "pc": "<p>PC向けの商品説明文です。</p>",
 *   "sp": "<p>スマートフォン向けの商品説明文です。</p>"
 * }
 * ```
 */
final readonly class ProductDescription extends BaseResponseDto
{
    /**
     * @param string|null $pc
     *  PC表示用の商品説明文（HTML を含む場合あり）
     *
     * @param string|null $sp
     *  スマートフォン表示用の商品説明文（HTML を含む場合あり）
     */
    public function __construct(
        public ?string $pc,
        public ?string $sp
    ) {}
}
