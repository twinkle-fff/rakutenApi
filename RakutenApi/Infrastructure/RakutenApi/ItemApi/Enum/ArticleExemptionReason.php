<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum;

/**
 * 楽天商品API：商品コード免除理由
 *
 * 商品コード（JAN / 製品コード等）の
 * 登録・表示が免除される理由を表す。
 */
enum ArticleExemptionReason: int
{
    case SET_PRODUCT = 1;
    case SERVICE_PRODUCT = 2;
    case SHOP_ORIGINAL_PRODUCT = 3;
    case OPTION_INVENTORY_PRODUCT = 4;
    case NO_APPLICABLE_PRODUCT_CODE = 5;
    case BUYING_CLUB_PRODUCT = 6;
}
