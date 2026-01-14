<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesApi;
require_once __DIR__."/../../../../vendor/autoload.php";

use HttpClient\Infrastructure\Enum\RequestType;
use HttpClient\Infrastructure\ValueObject\HttpParams;
use RakutenApi\Application\Port\RakutenApi\InventoriesApiPort;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\Dto\Request\UpsertVariantRequest;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\Enum\Mode;
use RakutenApi\Infrastructure\RakutenApi\Shared\Enum\ReturnType;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

final class InventoriesApi implements InventoriesApiPort{
    public RakutenApiClient $client;

    public const string ENDPOINT_PREFIX = "https://api.rms.rakuten.co.jp/es/2.1/inventories/manage-numbers/{manageNumber}/variants/{variantId}";

    public function __construct(?RakutenApiClient $client = null){
        $client ??= new RakutenApiClient();
        $this->client = $client;
    }

    public function upsertVariants(string $manageNumber, string $sku, array|UpsertVariantRequest $upsertVariantRequest): bool
    {
        $url = $this->buildURL($manageNumber,$sku);
        $normalizedHttpParams = $this->normalizeHttpParams($upsertVariantRequest);
        $res = $this->client->request(RequestType::PUT,$url,$normalizedHttpParams,returnType:ReturnType::TEXT);
        echo $res;
        throw new \Exception('Not implemented');
    }

    private function buildURL(string $manageNumber, string $sku,){
        return str_replace(["{manageNumber}","{variantId}"],[$manageNumber,$sku],self::ENDPOINT_PREFIX);
    }

    private function normalizeHttpParams(array|UpsertVariantRequest $upsertVariantRequest){
        $normalizedArray = $upsertVariantRequest->toArray();
        return HttpParams::fromArray($normalizedArray);
    }

}

if(basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])){
    require_once __DIR__."/../../../../vendor/autoload.php";

    $ia = new InventoriesApi();
    $upsertVariantRequest = UpsertVariantRequest::empty()
        ->set("mode",Mode::ABSOLUTE)
        ->set("quantity",500);
    $ia->upsertVariants("22m0e3iuhb7rcorc","ippon",$upsertVariantRequest);


}
