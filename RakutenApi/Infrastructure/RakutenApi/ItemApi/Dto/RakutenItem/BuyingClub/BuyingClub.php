<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\BuyingClub;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：頒布会（Buying Club）設定 DTO
 *
 * 楽天の頒布会（Buying Club）商品に関する設定情報を表す。
 * 一定回数の商品配送を前提とした販売形態の制御に用いられる。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 配送回数、表示制御、配送条件フラグなどの設定値を保持する
 * - 項目が存在しないケースを考慮し、各値は null を許容する
 *
 * 親 DTO（RakutenItem など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "numberOfDeliveries": 6,
 *   "displayItems": true,
 *   "items": [
 *     { "name": "第1回 お届け商品" },
 *     { "name": "第2回 お届け商品" }
 *   ],
 *   "shippingDateFlag": true,
 *   "shippingIntervalFlag": false
 * }
 * ```
 */
final readonly class BuyingClub extends BaseResponseDto
{
    /**
     * @param int|null $numberOfDeliveries
     *  頒布会における配送回数
     *
     * @param bool|null $displayItems
     *  頒布会の商品一覧を表示するかどうか
     *
     * @param array|null $items
     *  頒布会で配送される商品情報の一覧
     *  （要素構造は API 仕様に依存するため、ここでは汎用 array とする）
     *
     * @param bool|null $shippingDateFlag
     *  配送開始日を指定可能かどうか
     *
     * @param bool|null $shippingIntervalFlag
     *  配送間隔を指定可能かどうか
     */
    public function __construct(
        public ?int $numberOfDeliveries,
        public ?bool $displayItems,
        public ?array $items,
        public ?bool $shippingDateFlag,
        public ?bool $shippingIntervalFlag,
    ) {}
}
