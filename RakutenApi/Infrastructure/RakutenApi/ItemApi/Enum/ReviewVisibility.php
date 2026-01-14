<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum;

enum ReviewVisibility: string {
    case SHOP_SETTING = "SHOP_SETTING";
    case VISIBLE = "VISIBLE";
    case HIDDEN = "HIDDEN";
}
