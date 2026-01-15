<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesApi\UpsertVariants\Dto\Request\OperationLeadTime;

use ApiDto\BaseRequestDto\BaseRequestDto;

/**
 * 配送リードタイム設定（在庫更新リクエスト用 DTO）
 *
 * 楽天RMS Inventories API に対して、
 * SKU（バリエーション）の在庫情報を更新する際に指定する
 * 配送目安日数（リードタイム）設定を表すリクエストDTO。
 *
 * 本DTOは「設定用」であり、
 * 取得レスポンスで使用される OperationLeadTime とは用途が異なる。
 *
 * 各プロパティは日数そのものではなく、
 * 楽天RMS側で定義されている「配送目安日数マスタ」のIDを指定する。
 *
 * 未指定の場合は null を指定し、既存設定を変更しない挙動となる。
 */
final readonly class OperationLeadTime extends BaseRequestDto
{
    /**
     * @param int|null $normalDeliveryTimeId
     *        通常配送時の配送目安日数ID
     *
     * @param int|null $backOrderDeliveryTimeId
     *        バックオーダー（入荷待ち）時の配送目安日数ID
     */
    public function __construct(
        public ?int $normalDeliveryTimeId,
        public ?int $backOrderDeliveryTimeId,
    ) {}
}
