<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum;

enum PriceDisplayType:string{
    case REFERENCE_PRICE = "REFERENCE_PRICE";
    case SHOP_SETTING = "SHOP_SETTING";
    case OPEN_PRICE = "OPEN_PRICE";
}
