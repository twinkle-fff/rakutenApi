<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\DelvDateResult\DelvDateModelList\DelvDateModel;

use ApiDto\BaseResponseDto\BaseResponseDto;

/**
 * 在庫設定API（GetDelvDateMaster）レスポンスの配送日モデルDTO
 *
 * 楽天RMSに登録されている配送日設定の1件分を表現する。
 * 配送日番号と、その表示用ラベル（キャプション）を保持する。
 *
 * 主な用途:
 * - 配送日設定一覧の取得
 * - UI表示用ラベルの取得
 * - 設定値の参照・選択
 */
readonly class DelvDateModel extends BaseResponseDto{

    /**
     * @param string $delvdateNumber 配送日番号（識別子）
     * @param string $delvdateCaption 配送日表示名（ユーザー向けラベル）
     */
    public function __construct(
        public string $delvdateNumber,
        public string $delvdateCaption
    )
    {}
}
