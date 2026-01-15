<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesApi\UpsertVariants\Dto\Request;

use ApiDto\BaseRequestDto\BaseRequestDto;

use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\Enum\Mode;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\UpsertVariants\Dto\Request\OperationLeadTime\OperationLeadTime;

/**
 * SKU（バリエーション）在庫 Upsert リクエストDTO
 *
 * 楽天RMS Inventories API に対して、
 * 指定SKUの在庫情報を「登録または更新（Upsert）」するための入力DTO。
 *
 * - mode により在庫数 quantity の解釈が変わる（例：絶対指定／加算減算 等）
 * - operationLeadTime は配送リードタイム設定（任意）
 * - shipFromIds は出荷元（発送拠点）IDの配列（任意）
 *
 * ※ shipFromIds は `int[]` を想定（ID配列）
 */
final readonly class UpsertVariantRequest extends BaseRequestDto
{
    /**
     * @param Mode $mode
     *        在庫更新モード（quantity の解釈を決める）
     *
     * @param int $quantity
     *        在庫数（mode により「絶対値」または「差分値」等として扱われる）
     *
     * @param OperationLeadTime|null $operationLeadTime
     *        配送リードタイム設定（通常／バックオーダー）
     *
     * @param int[]|null $shipFromIds
     *        出荷元（shipFrom）ID配列
     */
    public function __construct(
        public Mode $mode = Mode::ABSOLUTE,
        public int $quantity = 500,
        public ?OperationLeadTime $operationLeadTime = null,
        public ?array $shipFromIds = null
    ) {}
}
