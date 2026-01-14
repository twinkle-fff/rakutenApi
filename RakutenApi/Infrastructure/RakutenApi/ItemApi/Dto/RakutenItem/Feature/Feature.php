<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Feature;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\InventoryDisplay;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\ReviewVisibility;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\SearchVisibility;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：商品機能・表示制御設定 DTO
 *
 * 商品ページや購入導線に関する各種表示・機能フラグをまとめて表す。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 検索表示可否、在庫表示方法、カートボタン表示、レビュー表示設定などを保持する
 * - 楽天側の仕様上、必須項目と任意項目が混在するため、型に応じて null 許容を行う
 *
 * 親 DTO（RakutenItem など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "searchVisibility": "VISIBLE",
 *   "displayNormalCartButton": true,
 *   "displaySubscriptionCartButton": false,
 *   "inventoryDisplay": "DISPLAY",
 *   "lowStockThreshold": 5,
 *   "shopContact": true,
 *   "review": "VISIBLE",
 *   "displayManufacturerContents": false,
 *   "socialGiftFlag": true
 * }
 * ```
 */
final readonly class Feature extends BaseResponseDto
{
    /**
     * @param SearchVisibility|null $searchVisibility
     *  楽天検索結果への表示可否設定
     *
     * @param bool $displayNormalCartButton
     *  通常購入用カートボタンを表示するかどうか
     *
     * @param bool|null $displaySubscriptionCartButton
     *  定期購入用カートボタンを表示するかどうか
     *
     * @param InventoryDisplay $inventoryDisplay
     *  在庫数の表示方法設定
     *
     * @param int|null $lowStockThreshold
     *  在庫僅少と判定する数量の閾値
     *
     * @param bool $shopContact
     *  ショップへの問い合わせリンクを表示するかどうか
     *
     * @param ReviewVisibility $review
     *  レビュー表示設定（ショップ設定に従う / 表示 / 非表示）
     *
     * @param bool $displayManufacturerContents
     *  メーカー提供コンテンツを表示するかどうか
     *
     * @param bool|null $socialGiftFlag
     *  ソーシャルギフト対応可否
     */
    public function __construct(
        public ?SearchVisibility $searchVisibility,
        public bool $displayNormalCartButton,
        public ?bool $displaySubscriptionCartButton,
        public InventoryDisplay $inventoryDisplay,
        public ?int $lowStockThreshold,
        public bool $shopContact,
        public ReviewVisibility $review,
        public bool $displayManufacturerContents,
        public ?bool $socialGiftFlag
    ) {}
}
