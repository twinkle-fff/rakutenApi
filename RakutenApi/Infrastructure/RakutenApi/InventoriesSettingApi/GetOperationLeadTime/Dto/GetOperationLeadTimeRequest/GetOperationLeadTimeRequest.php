<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeRequest;

use ApiDto\BaseRequestDto\BaseRequestDto;

/**
 * 在庫設定API（GetOperationLeadTime）リクエストDTO
 *
 * 楽天RMSの「出荷リードタイム（operationLeadTime）」マスタを取得するためのリクエストを表現する。
 *
 * operationLeadTimeId を指定することで、特定のリードタイムのみ取得可能。
 * 未指定（null）の場合は、全件取得を行う。
 *
 * 主な用途:
 * - 出荷リードタイムマスタの取得
 * - 特定IDのリードタイム設定の参照
 * - 在庫設定・配送設定ロジックへの連携
 */
readonly class GetOperationLeadTimeRequest extends BaseRequestDto
{
    /**
     * @param int|null $operationLeadTimeId 出荷リードタイムID（任意）
     */
    public function __construct(
        public ?int $operationLeadTimeId = null
    ) {}
}
