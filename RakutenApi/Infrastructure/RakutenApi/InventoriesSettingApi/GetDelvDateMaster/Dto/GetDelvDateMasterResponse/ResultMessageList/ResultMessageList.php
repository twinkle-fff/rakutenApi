<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\ResultMessageList;

use ApiDto\BaseResponseDto\BaseResponseDto;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\ResultMessageList\ResultMessage\ResultMessage;

/**
 * 在庫設定API（GetDelvDateMaster）レスポンスのメッセージラッパーDTO
 *
 * APIレスポンスの `resultMessageList` 要素を表現する。
 * 本クラスはメッセージ配列のラッパーであり、実際のメッセージ本体は
 * {@see ResultMessage} DTO に格納される。
 *
 * 注意:
 * - 本API仕様では resultMessage は単数要素として返却されるケースを想定している
 * - 将来的に複数件返却される場合は、配列（ResultMessage[]）への変更が必要
 *
 * 主な用途:
 * - API実行結果のメッセージ取得
 * - エラーハンドリング
 * - ログ出力
 */
readonly class ResultMessageList extends BaseResponseDto
{
    /**
     * @param ResultMessage $resultMessage APIレスポンスのメッセージ
     */
    public function __construct(
        public ResultMessage $resultMessage
    ) {}
}
