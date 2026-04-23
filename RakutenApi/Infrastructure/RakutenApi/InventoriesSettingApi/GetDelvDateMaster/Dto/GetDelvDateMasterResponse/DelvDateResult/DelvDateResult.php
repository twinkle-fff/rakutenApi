<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\DelvDateResult;

use ApiDto\BaseResponseDto\BaseResponseDto;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\DelvDateResult\DelvDateModelList\DelvDateModelList;

/**
 * 在庫設定API（GetDelvDateMaster）の result 部分DTO
 *
 * result は delvdateMasterList を1つ持つラッパーオブジェクト
 */
readonly class DelvDateResult extends BaseResponseDto
{
    /**
     * 配送日マスタ一覧
     */
    public DelvDateModelList $delvdateMasterList;

    /**
     * @param DelvDateModelList $delvdateMasterList 配送日一覧
     */
    public function __construct(
        DelvDateModelList $delvdateMasterList
    ){
        $this->delvdateMasterList = $delvdateMasterList;
    }
}
