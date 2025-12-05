<?php
namespace RakutenApi\Infrastructure\RakutenApi\NavigationApi;
use Exception;
use HttpClient\Infrastructure\Enum\RequestType;
use RakutenApi\Application\Port\NavigationPort;
use RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute\ItemAttributeResponse;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

class NavigationApi implements NavigationPort{

    private const string GET_ATTRIBUTE_ENDPOINT_PREFIX = "https://api.rms.rakuten.co.jp/es/2.0/navigation/genres/{genreId}/attributes/";

    private RakutenApiClient $client;
    public function __construct(?RakutenApiClient $client = null)
    {
        $this->client = $client ?? new RakutenApiClient();
    }

    public function getItemAttribute(int $genreId): ItemAttributeResponse
    {
        $url = str_replace("{genreId}",(string)$genreId,self::GET_ATTRIBUTE_ENDPOINT_PREFIX);
        $resp = $this->client->request(
            RequestType::GET,
            $url,
            []
        );

        return ItemAttributeResponse::fromResponse($resp);
    }
}


if(basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])){
    $na = new NavigationApi();
    echo json_encode($na->getItemAttribute("410946"),JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

}
