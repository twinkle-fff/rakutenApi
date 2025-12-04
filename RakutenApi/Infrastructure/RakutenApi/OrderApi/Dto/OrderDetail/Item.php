<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天注文詳細API：商品明細情報 DTO
 *
 * 注文内の商品1行（明細行）を表し、商品名・数量・価格・在庫/取引フラグ、
 * SKU リストなど必要情報をまとめて保持します。
 *
 * BaseResponseDto を継承しているため、fromResponse() によって
 * APIレスポンス配列から自動で型変換・必須チェックが行われます。
 *
 * 使用例：
 *     $item = Item::fromResponse($response['item']);
 *
 * ※ SkuModelList について：
 *     BaseResponseDto の applyChildModel により、配列要素それぞれが
 *     ItemSKU::fromResponse() によって DTO 化されます。
 */
readonly class Item extends BaseResponseDto
{
    /**
     * @param int         $itemDetailId          明細行ID
     * @param string      $itemName              商品名
     * @param string      $itemId               商品ID（楽天商品ID）
     * @param int|null    $itemNumber            商品番号（null 許容）
     * @param string      $manageNumber          管理番号
     * @param int         $price                 単価（税抜）
     * @param int         $units                 購入数量
     * @param int         $includePostageFlag    送料込みフラグ（0/1）
     * @param int         $includeTaxFlag        税込みフラグ（0/1）
     * @param string      $selectedChoice        選択肢情報（例：カラー/サイズ）
     * @param int         $pointRate             獲得ポイント率
     * @param int         $pointType             ポイント種別
     * @param int         $inventoryType         在庫種別（通常/予約/倉庫）
     * @param string      $delvdateInfo          お届け目安情報
     * @param int         $restoreInventoryFlag  在庫戻しフラグ（キャンセル時利用）
     * @param int         $dealFlag              取引区分フラグ
     * @param int         $drugFlag              医薬品区分フラグ
     * @param int         $deleteItemFlag        削除商品フラグ
     * @param float       $taxRate               税率（例：10.0）
     * @param int         $priceTaxIncl          税込金額
     * @param int         $isSingleItemShipping  個別配送フラグ
     * @param ItemSKU[]   $SkuModelList          SKU 情報配列（ItemSKU DTO の配列）
     */
    protected function __construct(
        public int $itemDetailId,
        public string $itemName,
        public string $itemId,
        public ?int $itemNumber,
        public string $manageNumber,
        public int $price,
        public int $units,
        public int $includePostageFlag,
        public int $includeTaxFlag,
        public string $selectedChoice,
        public int $pointRate,
        public int $pointType,
        public int $inventoryType,
        public string $delvdateInfo,
        public int $restoreInventoryFlag,
        public int $dealFlag,
        public int $drugFlag,
        public int $deleteItemFlag,
        public float $taxRate,
        public int $priceTaxIncl,
        public int $isSingleItemShipping,
        public array $SkuModelList
    ) {}
}
