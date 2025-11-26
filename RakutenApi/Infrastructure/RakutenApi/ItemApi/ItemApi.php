<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi;

use RakutenApi\Application\Port\RakutenApi\ItemAPiPort;
use RakutenApi\Domain\ItemSearch\ValueObject\ItemSearchParams;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

class ItemApi implements ItemAPiPort{
    private RakutenApiClient $client;


    public function __construct(?RakutenApiClient $rakutenApiClient = null){
        $this->client = $rakutenApiClient ?? new RakutenApiClient();
    }

    public function searchItems(array|ItemSearchParams|null $params = null): array
    {
        $params ??= $this->defaultParams();
        $normalizedParams = ($params instanceof ItemSearchParams) ? $params : ItemSearchParams::fromArray($params);
        $params = $normalizedParams->toArray();



        throw new \Exception('Not implemented');
    }

    private function defaultParams(){
        $params = ItemSearchParams::empty();
        $params->setSortKey("created");
        $params->setHits("hits");
        $params->setIsInventoryIncluded(true);
        return $params;
    }


}

if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){
    require_once __DIR__."/../../../../vendor/autoload.php";

    
}
