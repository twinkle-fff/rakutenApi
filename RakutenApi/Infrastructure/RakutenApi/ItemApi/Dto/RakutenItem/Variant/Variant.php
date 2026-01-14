<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Image\Image;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\ArticleNumber\ArticleNumber;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\ReferencePrice\ReferencePrice;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\Spec\Spec;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\SubscriptionPrice\SubscriptionPrice;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\VariantAttribute\VariantAttribute;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\VariantOtherOptions\VariantOtherOptions;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail\Shipping;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：商品バリエーション DTO
 *
 * 商品に紐づく 1 つのバリエーション（SKU 相当）を表す集約 DTO。
 *
 * 本 DTO は、
 * - SKU 識別情報
 * - 価格・配送・在庫関連情報
 * - 表示用情報（画像・仕様・属性）
 * を横断的に保持する。
 *
 * 本 DTO が表す Variant は、
 * - 商品の最小販売単位
 * - 注文・在庫・配送判定の基準単位
 * となる存在である。
 *
 * ## 配列プロパティについて
 * 本クラスの `?array` 型プロパティは、
 * 特別な注記がない限り {@see ARRAY_CHILD_MAP} に従って
 * **要素が DTO に正規化される配列**である。
 *
 * - list / assoc の別は API レスポンスに依存する
 * - assoc 配列の場合、キーは維持される
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 表示・参照用途に特化し、ビジネスロジックは含まない
 *
 * 想定用途:
 * - 商品詳細表示
 * - バリエーション選択
 * - 在庫・配送条件の判定材料
 */
final readonly class Variant extends BaseResponseDto
{
    /**
     * 配列プロパティの要素型マップ。
     *
     * - images     : {@see Image}[]
     * - specs      : {@see Spec}[]
     * - attributes : {@see VariantAttribute}[]
     */
    protected const array ARRAY_CHILD_MAP = [
        'images'     => Image::class,
        'specs'      => Spec::class,
        'attributes' => VariantAttribute::class,
    ];

    /**
     * @param string|null $merchantDefinedSkuId
     *  店舗側で定義された SKU 識別子
     *
     * @param array|null $selectorValues
     *  バリエーションセレクタの選択値マップ
     *  （例：{ "color": "Red", "size": "M" }）
     *
     * @param Image[]|null $images
     *  バリエーションに紐づく商品画像一覧
     *
     * @param bool|null $restockOnCancel
     *  キャンセル時に在庫を戻すかどうか
     *
     * @param bool|null $backOrderFlag
     *  取り寄せ・予約商品フラグ
     *
     * @param int|null $normalDeliveryDateId
     *  通常配送時の配送日目安ID
     *
     * @param int|null $backOrderDeliveryDateId
     *  取り寄せ時の配送日目安ID
     *
     * @param int|null $orderQuantityLimit
     *  注文数量上限
     *
     * @param ReferencePrice|null $referencePrice
     *  表示・比較用の参照価格情報
     *
     * @param VariantOtherOptions|null $features
     *  バリエーションに付随する補助オプション
     *
     * @param bool|null $hidden
     *  非表示バリエーションかどうか
     *
     * @param string|null $standardPrice
     *  通常販売価格（表示用）
     *
     * @param SubscriptionPrice|null $subscriptionPrice
     *  定期購入時の価格情報
     *
     * @param string[]|null $articleNumberForSet
     *  セット商品用の商品コード一覧
     *
     * @param ArticleNumber|null $articleNumber
     *  商品コード情報（免除理由含む）
     *
     * @param Shipping $shipping
     *  配送・送料設定
     *
     * @param Spec[]|null $specs
     *  商品仕様（スペック）一覧
     *
     * @param VariantAttribute[]|null $attributes
     *  補足的な属性情報一覧
     */
    public function __construct(
        public ?string $merchantDefinedSkuId,
        public ?array $selectorValues,
        public ?array $images,
        public ?bool $restockOnCancel,
        public ?bool $backOrderFlag,
        public ?int $normalDeliveryDateId,
        public ?int $backOrderDeliveryDateId,
        public ?int $orderQuantityLimit,
        public ?ReferencePrice $referencePrice,
        public ?VariantOtherOptions $features,
        public ?bool $hidden,
        public ?string $standardPrice,
        public ?SubscriptionPrice $subscriptionPrice,
        public ?array $articleNumberForSet,
        public ?ArticleNumber $articleNumber,
        public Shipping $shipping,
        public ?array $specs,
        public ?array $attributes
    ) {}
}
