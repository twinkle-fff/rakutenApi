<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum;

/**
 * 楽天商品API：単品配送区分
 *
 * 他商品との同梱ができない、または配送条件が特殊な商品区分を表す。
 */
enum SingleItemShipping: int
{
    case NONE = 0;
    case DIRECT_FROM_PRODUCTION_AREA = 1;
    case DIRECT_FROM_MANUFACTURER = 2;
    case CASE_SALE_PRODUCT = 3;
    case LONG_OR_IRREGULAR_SHAPE_PRODUCT = 4;
    case DIFFERENT_SHIPPING_ORIGIN = 5;
    case DIFFERENT_TEMPERATURE_ZONE = 6;
}
