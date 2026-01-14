<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Subscription;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：定期購入設定 DTO
 *
 * 商品が定期購入に対応しているか、および
 * 定期購入時に指定可能な条件の有無を表す。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 定期購入に関するフラグ情報のみを保持するシンプルな DTO
 * - 各フラグは未設定・非対応ケースを考慮し null を許容する
 *
 * 親 DTO（RakutenItem など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "shippingDateFlag": true,
 *   "shippingIntervalFlag": false
 * }
 * ```
 */
final readonly class Subscription extends BaseResponseDto
{
    /**
     * @param bool|null $shippingDateFlag
     *  定期購入時に配送開始日を指定可能かどうか
     *
     * @param bool|null $shippingIntervalFlag
     *  定期購入時に配送間隔を指定可能かどうか
     */
    public function __construct(
        public ?bool $shippingDateFlag,
        public ?bool $shippingIntervalFlag
    ) {}
}
