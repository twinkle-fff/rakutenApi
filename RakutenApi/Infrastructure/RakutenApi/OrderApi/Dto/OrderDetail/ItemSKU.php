<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use Exception;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 注文詳細 API 内の SKU 情報（Item/SKU 要素）を表す DTO。
 *
 * 楽天APIの order/detail レスポンスに含まれる
 * variantId / merchantDefinedSkuId / skuInfo を扱う。
 *
 * @package RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail
 */
readonly class ItemSKU extends BaseResponseDto
{
    /**
     * @param string      $variantId
     *   商品バリエーションID（例：サイズ/カラーの内部ID）。
     *
     * @param string|null $merchantDefinedSkuId
     *   店舗側で独自に管理している SKU。存在しない場合は null。
     *
     * @param string|null $skuInfo
     *   SKU に関する補足情報（楽天API上で skuInfo フィールドに相当）。
     */
    protected function __construct(
        private string  $variantId,
        private ?string $merchantDefinedSkuId,
        private ?string $skuInfo
    ) {}
}
