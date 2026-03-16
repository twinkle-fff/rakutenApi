<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem;

use DateTime;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\AccessControl\AccessControl;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\BuyingClub\BuyingClub;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\CustomizationOption\CustomizationOption;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Feature\Feature;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Image\Image;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Layout\Layout;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Payment\Payment;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\PointCampaign\PointCampaign;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Precautions\Precautions;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\ProductDescription\ProductDescription;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\PurchasablePeriod\PurchasablePeriod;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Subscription\Subscription;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\Variant;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\VariantSelector\VariantSelector;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Video\Video;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\WhiteBgImage\WhiteBgImage;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\ItemType;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：商品本体 DTO
 *
 * 楽天の商品情報を表現する中心DTO。
 * 商品番号・商品名・商品説明・画像・バリエーション・販売制御・ポイント設定など、
 * 商品1件に紐づく主要情報をまとめて保持する。
 *
 * このDTOは BaseResponseDto を継承しており、
 * APIレスポンス配列から {@see BaseResponseDto::fromResponse()} によって生成されることを想定する。
 *
 * また、配列形式で返却される一部の子要素については、
 * {@see self::ARRAY_CHILD_MAP} を用いて各要素を対応する子DTOへ変換する。
 *
 * 対象例:
 * - images               → Image[]
 * - customizationOptions → CustomizationOption[]
 * - variantSelectors     → VariantSelector[]
 * - variants             → Variant[]
 */
final readonly class RakutenItem extends BaseResponseDto
{
    /**
     * 配列形式で返る子要素と、その各要素に対応するDTOクラスの対応表。
     *
     * fromResponse() 側で配列要素を再帰変換する際に利用する。
     *
     * @var array<string, class-string>
     */
    protected const array ARRAY_CHILD_MAP = [
        'images'               => Image::class,
        'customizationOptions' => CustomizationOption::class,
        'variantSelectors'     => VariantSelector::class,
        'variants'             => Variant::class,
    ];

    /**
     * @param string $manageNumber
     *  商品管理番号
     *
     * @param string|null $itemNumber
     *  商品番号
     *
     * @param string $title
     *  商品名
     *
     * @param string|null $tagline
     *  キャッチコピー
     *
     * @param ProductDescription|null $productDescription
     *  PC/SP別の商品説明文
     *
     * @param string|null $salesDescription
     *  販売説明文
     *
     * @param Precautions|null $precautions
     *  注意事項情報
     *
     * @param ItemType $itemType
     *  商品種別
     *
     * @param array|null $images
     *  商品画像一覧
     *  {@see Image} の配列を想定する
     *
     * @param WhiteBgImage|null $whiteBgImage
     *  白背景画像
     *
     * @param Video|null $video
     *  商品動画情報
     *
     * @param string $genreId
     *  楽天ジャンルID
     *
     * @param array|null $tags
     *  商品タグ一覧
     *
     * @param bool $hideItem
     *  商品非表示フラグ
     *
     * @param bool $unlimitedInventoryFlag
     *  在庫数無制限フラグ
     *
     * @param array|null $customizationOptions
     *  項目選択肢・カスタマイズ設定一覧
     *  {@see CustomizationOption} の配列を想定する
     *
     * @param DateTime|null $releaseDate
     *  発売日
     *
     * @param PurchasablePeriod|null $purchasablePeriod
     *  購入可能期間
     *
     * @param Subscription|null $subscription
     *  定期購入設定
     *
     * @param BuyingClub|null $buyingClub
     *  共同購入設定
     *
     * @param Feature $features
     *  商品特徴・フラグ群
     *
     * @param AccessControl|null $accessControl
     *  アクセス制御設定
     *
     * @param Payment $payment
     *  支払い設定
     *
     * @param PointCampaign|null $pointCampaign
     *  ポイントキャンペーン設定
     *
     * @param int $itemDisplaySequence
     *  商品表示順
     *
     * @param Layout $layout
     *  商品ページレイアウト設定
     *
     * @param array|null $variantSelectors
     *  バリエーション選択肢一覧
     *  {@see VariantSelector} の配列を想定する
     *
     * @param array|null $variants
     *  SKU・バリエーション一覧
     *  {@see Variant} の配列を想定する
     *
     * @param DateTime $created
     *  作成日時
     *
     * @param DateTime $updated
     *  更新日時
     */
    public function __construct(
        public string $manageNumber,
        public ?string $itemNumber,
        public string $title,
        public ?string $tagline,
        public ?ProductDescription $productDescription,
        public ?string $salesDescription,
        public ?Precautions $precautions,
        public ItemType $itemType,
        public ?array $images,
        public ?WhiteBgImage $whiteBgImage,
        public ?Video $video,
        public string $genreId,
        public ?array $tags,
        public bool $hideItem,
        public bool $unlimitedInventoryFlag,
        public ?array $customizationOptions,
        public ?DateTime $releaseDate,
        public ?PurchasablePeriod $purchasablePeriod,
        public ?Subscription $subscription,
        public ?BuyingClub $buyingClub,
        public Feature $features,
        public ?AccessControl $accessControl,
        public Payment $payment,
        public ?PointCampaign $pointCampaign,
        public int $itemDisplaySequence,
        public Layout $layout,
        public ?array $variantSelectors,
        public ?array $variants,
        public DateTime $created,
        public DateTime $updated
    ) {}
}

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    $jsonFile = "/Library/WebServer/Documents/library/rakutenApi/tmp.json";

    $json = file_get_contents($jsonFile);
    $data = json_decode($json, true);

    foreach ($data as $datum) {
        $item = $datum["item"];
        var_dump(RakutenItem::fromResponse($item));
    }
}
