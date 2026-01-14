<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum;

enum ItemType:string {
    case NORMAL = "NORMAL";
    case PRE_ORDER = "PRE_ORDER";
    case BUYING_CLUB = "BUYING_CLUB";
}
