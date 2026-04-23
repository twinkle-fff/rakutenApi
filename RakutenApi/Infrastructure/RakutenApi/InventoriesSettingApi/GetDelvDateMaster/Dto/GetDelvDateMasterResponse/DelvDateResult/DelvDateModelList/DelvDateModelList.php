<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\DelvDateResult\DelvDateModelList;


use ApiDto\BaseResponseDto\BaseResponseDto;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\DelvDateResult\DelvDateModelList\DelvDateModel\DelvDateModel;

/**
 * 在庫設定API（GetDelvDateMaster）レスポンスの配送日モデル一覧DTO
 *
 * 楽天RMSに登録されている配送日設定（DelvDateModel）の一覧を保持する。
 * BaseResponseDto の ARRAY_CHILD_MAP により、
 * 配列要素は DelvDateModel DTO に自動変換される。
 *
 * 主な用途:
 * - 配送日設定一覧の取得
 * - UIでの選択肢生成
 * - 配送設定ロジックへの連携
 */
readonly class DelvDateModelList extends BaseResponseDto{

    /**
     * @var list<RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\DelvDateResult\DelvDateModelList\DelvDateModel\DelvDateModel>
     */
    public array $delvdateMaster;

    public function __construct(
        array $delvdateMaster
    ){
        $this->delvdateMaster = $delvdateMaster;
    }
}
