<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime;

use Exception;
use HttpClient\Infrastructure\Enum\RequestType;
use HttpClient\Infrastructure\ValueObject\HttpParams;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeRequest\GetOperationLeadTimeRequest;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\GetOperationLeadTimeResponse;
use RakutenApi\Infrastructure\RakutenApi\Shared\Enum\ReturnType;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;
use RuntimeException;

final class GetOperationLeadTime{

    private const string ENDPOINT_URL = "https://api.rms.rakuten.co.jp/es/1.0/shop/operationLeadTime";


    public function __construct(
        private RakutenApiClient $client
    )
    {}

    public function execute(GetOperationLeadTimeRequest|string|null $request):GetOperationLeadTimeResponse{
        $normalizedReuqest = $this->normalizeRequest($request);
        $params = $normalizedReuqest->toArray();
        $httpParams = HttpParams::fromArray($params);
        try{
            $res = $this->client->request(
                RequestType::GET,
                self::ENDPOINT_URL,
                $httpParams,
                returnType:ReturnType::TEXT
            );
        }catch(Exception $e){
            throw new RuntimeException("配送リードタイムの取得に失敗しました。RMSAPIへの問い合わせに失敗しました。",$e->getCode(),$e);
        }

        $parsedData = $this->parseXMLResponse($res);
        return GetOperationLeadTimeResponse::fromResponse($parsedData);
    }

    private function normalizeRequest(GetOperationLeadTimeRequest|string|null $request):GetOperationLeadTimeRequest{
        if($request === null){
            return GetOperationLeadTimeRequest::empty();
        }

        if(is_string($request)){
            return new GetOperationLeadTimeRequest($request);
        }

        return $request;
    }

    private function parseXMLResponse(string $res):array{
        $rawData = simplexml_load_string($res);
        if($rawData === false){
            throw new Exception("納期情報の取得に失敗しました。納期情報レスポンスXMLが解析できませんでした。\nレスポンス: {$res}");
        }

        $data = json_decode(json_encode($rawData),true);
        $err = json_last_error();
        $mes = json_last_error_msg();

        if($err !== JSON_ERROR_NONE){
            throw new Exception("納期情報の取得に失敗しました。納期情報を正しくパースできませんでした。detail:{$mes}\nレスポンス: {$res}");
        }
        return $data;
    }
}
