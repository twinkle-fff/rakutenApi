<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesApi\UpsertVariants;

use HttpClient\Infrastructure\Enum\RequestType;
use HttpClient\Infrastructure\ValueObject\HttpParams;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\Dto\Request\UpsertVariantRequest;
use RakutenApi\Infrastructure\RakutenApi\Shared\Enum\ReturnType;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

class UpsertVariants{
    private RakutenApiClient $client;
    public const string ENDPOINT_PREFIX = "https://api.rms.rakuten.co.jp/es/2.1/inventories/manage-numbers/{manageNumber}/variants/{variantId}";

    public function __construct(?RakutenApiClient $client = null){
        $client ??= new RakutenApiClient();
        $this->client = $client;
    }

    public function execute(string $manageNumber, string $sku, array|UpsertVariantRequest $upsertVariantRequest): bool
    {
        $url = $this->buildURL($manageNumber,$sku);
        $normalizedHttpParams = $this->normalizeHttpParams($upsertVariantRequest);
        $res = $this->client->request(RequestType::PUT,$url,$normalizedHttpParams,returnType:ReturnType::TEXT);
        return ($res??"") === "";
    }

    private function buildURL(string $manageNumber, string $sku,){
        return str_replace(["{manageNumber}","{variantId}"],[$manageNumber,$sku],self::ENDPOINT_PREFIX);
    }

    private function normalizeHttpParams(array|UpsertVariantRequest $upsertVariantRequest){
        $normalizedArray = $upsertVariantRequest->toArray();
        return HttpParams::fromArray($normalizedArray);
    }
}
