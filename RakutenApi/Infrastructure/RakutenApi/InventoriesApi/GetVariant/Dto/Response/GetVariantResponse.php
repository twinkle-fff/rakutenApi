<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesApi\GetVariant\Dto\Response;

use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\GetVariant\Dto\Response\OperationLeadTime\OperationLeadTime;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * SKU（バリエーション）在庫情報取得レスポンスDTO
 *
 * 楽天RMS Inventories API（UpsertVariants / GetVariant）において、
 * 特定バリエーション（SKU）単位の在庫・配送・管理情報を表すレスポンスDTO。
 *
 * 本DTOは「商品（Item）」ではなく、
 * 在庫管理の最小単位である **Variant（SKU）** を対象とする。
 *
 * ---
 * 主な用途：
 * - SKU別在庫数の取得
 * - 出荷元（shipFrom）との紐付け確認
 * - 配送リードタイム設定の取得
 * ---
 *
 * @property string $manageNumber
 *           RMS上の商品管理番号
 *
 * @property string $variantId
 *           バリエーション（SKU）ID
 *
 * @property int $quantity
 *           現在の在庫数（引当前の論理在庫）
 *
 * @property OperationLeadTime|null $operationLeadTime
 *           配送リードタイム設定
 *           - 通常配送
 *           - バックオーダー時
 *
 * @property int[]|null $shipFromIds
 *           出荷元（shipFrom）IDの配列
 *           倉庫・発送拠点との関連付けを示す
 *
 * @property string $created
 *           作成日時（ISO-8601形式の文字列）
 *
 * @property string $updated
 *           更新日時（ISO-8601形式の文字列）
 */
final readonly class GetVariantResponse extends BaseResponseDto
{
    /**
     * @param string $manageNumber
     *        RMS上の商品管理番号
     *
     * @param string $variantId
     *        バリエーション（SKU）ID
     *
     * @param int $quantity
     *        在庫数（論理在庫）
     *
     * @param OperationLeadTime|null $operationLeadTime
     *        配送リードタイム情報
     *
     * @param int[]|null $shipFromIds
     *        出荷元ID配列
     *
     * @param string $created
     *        作成日時（ISO-8601）
     *
     * @param string $updated
     *        更新日時（ISO-8601）
     */
    public function __construct(
        public string $manageNumber,
        public string $variantId,
        public int $quantity,
        public ?OperationLeadTime $operationLeadTime,
        public ?array $shipFromIds,
        public string $created,
        public string $updated
    ) {}
}
