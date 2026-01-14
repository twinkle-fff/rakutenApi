<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum;

enum InventoryDisplay:string{
    case DISPLAY_ABSOLUTE_STOCK_COUNT = "DISPLAY_ABSOLUTE_STOCK_COUNT";
    case HIDDEN_STOCK = "HIDDEN_STOCK";
    case DISPLAY_LOW_STOCK = "DISPLAY_LOW_STOCK";
}
