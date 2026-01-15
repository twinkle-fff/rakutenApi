<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesApi\GetVariant\Dto\Response\OperationLeadTime;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 配送リードタイム情報 DTO
 *
 * 楽天RMS Inventories API（SKU在庫・バリエーション系）において、
 * 通常配送および入荷待ち（バックオーダー）時の
 * 配送目安日数IDを表すレスポンスDTO。
 *
 * 本DTOは数値そのもの（日数）ではなく、
 * RMS側で定義されている「配送目安日数マスタ」のIDを保持する。
 *
 * - normalDeliveryTimeId:
 *   通常在庫がある場合の配送目安日数ID
 *
 * - backOrderDeliveryTimeId:
 *   在庫切れ・取り寄せ時（バックオーダー）の配送目安日数ID
 *
 * いずれも未設定の場合は null が返却される。
 *
 * @see BaseResponseDto
 */
final readonly class OperationLeadTime extends BaseResponseDto
{
    /**
     * @param int|null $normalDeliveryTimeId
     *        通常配送時の配送目安日数ID
     *
     * @param int|null $backOrderDeliveryTimeId
     *        バックオーダー時の配送目安日数ID
     */
    public function __construct(
        public ?int $normalDeliveryTimeId,
        public ?int $backOrderDeliveryTimeId
    ) {}
}
