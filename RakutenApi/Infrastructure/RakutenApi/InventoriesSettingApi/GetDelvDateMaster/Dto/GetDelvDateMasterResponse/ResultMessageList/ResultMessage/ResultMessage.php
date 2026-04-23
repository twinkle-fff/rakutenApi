<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\ResultMessageList\ResultMessage;

use ApiDto\BaseResponseDto\BaseResponseDto;

/**
 * 在庫設定API（GetDelvDateMaster）レスポンス内のメッセージDTO
 *
 * API実行時に返却されるメッセージ（エラー・警告・補足情報など）を表現する。
 * 複数件返却されるため、通常は配列として扱われる。
 *
 * 主な用途:
 * - エラー内容の判定
 * - 警告メッセージの表示
 * - ログ出力
 */
readonly class ResultMessage extends BaseResponseDto{

    /**
     * @param string $code メッセージコード（API定義の識別子）
     * @param string $message メッセージ本文
     */
    public function __construct(
        public string $code,
        public string $message
    )
    {}
}
