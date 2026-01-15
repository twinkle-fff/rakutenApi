<?php
namespace RakutenApi\Application\Port\RakutenApi;

use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\GetVariant\Dto\Response\GetVariantResponse;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\UpsertVariants\Dto\Request\UpsertVariantRequest;

/**
 * 楽天RMS 在庫（Inventories）API ポート
 *
 * Application層から楽天RMSの在庫管理機能へアクセスするための
 * 抽象インターフェース。
 *
 * 本ポートは以下を責務とする：
 * - SKU（バリエーション）単位の在庫情報取得
 * - SKU在庫情報の登録・更新（Upsert）
 *
 * 実装は Infrastructure 層に委ねられ、
 * Application / Domain 層は楽天RMS固有の実装詳細を意識しない。
 */
interface InventoriesApiPort
{
    /**
     * SKU（バリエーション）の在庫情報を登録・更新する
     *
     * 既存SKUが存在する場合は更新、
     * 存在しない場合は新規登録として扱われる（Upsert）。
     *
     * @param string $manageNumber
     *        RMS上の商品管理番号
     *
     * @param string $sku
     *        SKU（バリエーション識別子）
     *
     * @param UpsertVariantRequest|array $upsertVariantRequest
     *        在庫・配送・出荷元などを含む更新内容
     *        - DTO指定時：型安全な更新
     *        - array指定時：低レイヤ互換・動的用途向け
     *
     * @return bool
     *         更新処理が正常に完了した場合 true
     */
    public function upsertVariants(
        string $manageNumber,
        string $sku,
        array|UpsertVariantRequest $upsertVariantRequest
    ): bool;

    /**
     * SKU（バリエーション）の在庫情報を取得する
     *
     * @param string $manageNumber
     *        RMS上の商品管理番号
     *
     * @param string $sku
     *        SKU（バリエーション識別子）
     *
     * @return GetVariantResponse
     *         SKU単位の在庫・配送・管理情報レスポンスDTO
     */
    public function getVariant(
        string $manageNumber,
        string $sku
    ): GetVariantResponse;
}
