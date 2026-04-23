<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\ResultMessageModelList;

use ApiDto\BaseResponseDto\BaseResponseDto;

/**
 * 在庫設定API（GetOperationLeadTime）レスポンスのメッセージ一覧DTO
 *
 * APIレスポンスの `resultMessageList` 要素を表現する。
 * メッセージ（ResultMessage）の配列を保持し、
 * エラー・警告・補足情報などを扱う。
 *
 * 本クラスは、XML→JSON変換時に発生する
 * 「単数オブジェクト / 配列」の揺れを吸収する役割を持つ。
 *
 * 例:
 * - 単数:
 *   resultMessage: { ... }
 * - 複数:
 *   resultMessage: [{ ... }, { ... }]
 *
 * 主な用途:
 * - API実行結果の確認
 * - エラーハンドリング
 * - ログ出力
 */
readonly class ResultMessageModelList extends BaseResponseDto
{
    /**
     * メッセージ一覧
     *
     * @var list<RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\ResultMessageModelList\ResultMessage\ResultMessage>
     */
    public array $resultMessage;

    /**
     * @param array $resultMessage メッセージ配列（単数・複数どちらも許容）
     */
    public function __construct(array $resultMessage)
    {
        // 単数オブジェクト（連想配列）の場合は配列に正規化
        if (!array_is_list($resultMessage)) {
            $resultMessage = [$resultMessage];
        }
        $this->resultMessage = $resultMessage;
    }
}
