<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum;

enum PriceDisplayMessageType: int
{
    case SHOP_REGULAR_PRICE = 1;
    case MANUFACTURER_SUGGESTED_RETAIL_PRICE = 2;
    case PRICE_NAVIGATION_REFERENCE = 4;
}
