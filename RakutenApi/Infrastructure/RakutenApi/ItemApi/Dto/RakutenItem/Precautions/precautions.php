<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Precautions;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：注意事項 DTO
 *
 * 商品購入時・利用時に関する注意文言や同意事項を表す。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 表示用の注意説明文と、同意・了承を伴う文言を保持する
 * - どちらも存在しないケースがあるため null を許容する
 *
 * 親 DTO（RakutenItem など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "description": "ご注文後のキャンセルはお受けできません。",
 *   "agreement": "上記内容に同意の上、ご購入ください。"
 * }
 * ```
 */
final readonly class Precautions extends BaseResponseDto
{
    /**
     * @param string|null $description
     *  注意事項の説明文（購入前に表示される文言）
     *
     * @param string|null $agreement
     *  同意・了承を求める文言
     */
    public function __construct(
        public ?string $description,
        public ?string $agreement
    ) {}
}
