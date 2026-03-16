<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\RakutenItem;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：商品 + 在庫情報 DTO
 *
 * 商品情報（RakutenItem）と、その商品に紐づく在庫情報をまとめて保持するDTO。
 *
 * 主な用途:
 * - 商品APIのレスポンスをアプリケーション側で扱いやすい形にまとめる
 * - 商品情報とSKU単位の在庫情報を同時に返す場面で利用
 *
 * BaseResponseDto を継承しており、
 * APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成されることを想定する。
 *
 * 想定構造例:
 * ```json
 * {
 *   "item": { ...RakutenItem... },
 *   "inventory": [
 *     {
 *       "sku": "ABC-001",
 *       "stock": 10
 *     },
 *     {
 *       "sku": "ABC-002",
 *       "stock": 5
 *     }
 *   ]
 * }
 * ```
 *
 * - `item`      : 商品本体情報
 * - `inventory` : SKU単位の在庫情報配列（SKU未使用商品の場合は null の可能性あり）
 */
final readonly class RakutenItemInventory extends BaseResponseDto
{
    /**
     * @param RakutenItem $item
     *  商品本体情報DTO
     *
     * @param array|null $inventory
     *  SKUごとの在庫情報配列
     *  APIレスポンスにSKU在庫情報が含まれる場合のみ設定される。
     *  SKU未使用商品などでは null になる可能性がある。
     */
    public function __construct(
        public RakutenItem $item,
        public ?array $inventory
    ) {}
}
