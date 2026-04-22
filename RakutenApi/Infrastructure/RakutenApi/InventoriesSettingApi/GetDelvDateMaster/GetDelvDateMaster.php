<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster;

use Exception;
use HttpClient\Infrastructure\Enum\RequestType;
use HttpClient\Infrastructure\ValueObject\HttpParams;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDataMasterRequest\GetDelvDataMasterRequest;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\GetDelvDateMasterResponse;
use RakutenApi\Infrastructure\RakutenApi\Shared\Enum\ReturnType;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;
use RuntimeException;

final class GetDelvDateMaster{

    private const string ENDPOINT_URL = "https://api.rms.rakuten.co.jp/es/1.0/shop/delvdateMaster";

    public function __construct(
        private RakutenApiClient $client
    )
    {}
    public function execute(GetDelvDataMasterRequest|string|null $request):GetDelvDateMasterResponse{
        $normalizedRequest = $this->normalizeRequest($request);
        $params = $normalizedRequest->toArray();
        $httpParams = HttpParams::fromArray($params);
        try{
            $response = $this->client->request(
                RequestType::GET,
                self::ENDPOINT_URL,
                $httpParams,
                returnType: ReturnType::TEXT
            );
        }catch(Exception $e){
            throw new RuntimeException("納期情報の取得に失敗しました。楽天APIリクエストに失敗しました。",$e->getCode(),$e);
        }


        $parsedData = $this->parseXMLResponse($response);
        return GetDelvDateMasterResponse::fromResponse($parsedData);
    }

    private function normalizeRequest(GetDelvDataMasterRequest|string|null $request):GetDelvDataMasterRequest{
        if($request === null){
            return GetDelvDataMasterRequest::empty();
        }
        if(is_string($request)){
            return GetDelvDataMasterRequest::fromString($request);
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
