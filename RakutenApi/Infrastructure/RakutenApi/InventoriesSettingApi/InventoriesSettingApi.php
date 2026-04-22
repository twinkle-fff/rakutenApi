<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi;

use RakutenApi\Application\Port\RakutenApi\Del;
use RakutenApi\Application\Port\RakutenApi\InventoriesSettingApiPort;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDataMasterRequest\GetDelvDataMasterRequest;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\GetDelvDateMasterResponse;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\GetDelvDateMaster;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

final class InventoriesSettingApi implements InventoriesSettingApiPort{
    private GetDelvDateMaster $getDelvDateMastar;

    public function __construct(
        ?RakutenApiClient $client = null
    )
    {
        $client ??= new RakutenApiClient();
        $this->getDelvDateMastar = new GetDelvDateMaster($client);
    }

    public function getDelvDateMaster(GetDelvDataMasterRequest|string|null $request): GetDelvDateMasterResponse
    {
        return $this->getDelvDateMastar->execute($request);
    }

}
