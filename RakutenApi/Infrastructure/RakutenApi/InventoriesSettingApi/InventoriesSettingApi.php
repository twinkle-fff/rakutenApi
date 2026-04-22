<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi;

use RakutenApi\Application\Port\RakutenApi\Del;
use RakutenApi\Application\Port\RakutenApi\InventoriesSettingApiPort;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDataMasterRequest\GetDelvDataMasterRequest;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\GetDelvDateMasterResponse;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\GetDelvDateMaster;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeRequest\GetOperationLeadTimeRequest;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\GetOperationLeadTimeResponse;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\GetOperationLeadTime;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

final class InventoriesSettingApi implements InventoriesSettingApiPort{
    private GetDelvDateMaster $getDelvDateMastar;
    private GetOperationLeadTime $getOperationLeadTime;

    public function __construct(
        ?RakutenApiClient $client = null
    )
    {
        $client ??= new RakutenApiClient();
        $this->getDelvDateMastar = new GetDelvDateMaster($client);
        $this->getOperationLeadTime = new GetOperationLeadTime($client);
    }

    public function getDelvDateMaster(GetDelvDataMasterRequest|string|null $request): GetDelvDateMasterResponse
    {
        return $this->getDelvDateMastar->execute($request);
    }

    public function getOperationLeadTime(GetOperationLeadTimeRequest|string|null $request): GetOperationLeadTimeResponse
    {
        return $this->getOperationLeadTime($request);
    }

}
