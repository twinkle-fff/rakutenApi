<?php
namespace RakutenApi\Application\Port\RakutenApi;

use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDataMasterRequest\GetDelvDataMasterRequest;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\GetDelvDateMasterResponse;

interface InventoriesSettingApiPort{
    public function getDelvDateMaster(GetDelvDataMasterRequest|string|null $request):GetDelvDateMasterResponse;
}
