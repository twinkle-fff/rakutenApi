<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto;

// TODO: 消す
require_once(__DIR__."/../../../../../../vendor/autoload.php");

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
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\ProductDescription;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\PurchasablePeriod\PurchasablePeriod;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Subscription\Subscription;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\Variant;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\VariantSelector\VariantSelector;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Video\Video;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\WhiteBgImage\WhiteBgImage;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\ItemType;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

final readonly class RakutenItem extends BaseResponseDto
{
    protected const array ARRAY_CHILD_MAP = [
        'images'               => Image::class,
        'customizationOptions' => CustomizationOption::class,
        'variantSelectors'     => VariantSelector::class,
        'variants'             => Variant::class,
    ];

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


if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){
    $jsonFile = "/Library/WebServer/Documents/library/rakutenApi/tmp.json";

    $json = file_get_contents($jsonFile);
    $data = json_decode($json,true);

    foreach($data as $datum){
        $item = $datum["item"];
        var_dump(RakutenItem::fromResponse($item));
    }

}
