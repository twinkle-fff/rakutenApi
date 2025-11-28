<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\ConfirmOrder;

use Exception;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;

readonly class ComfirmOrderResponse{
    private function __construct(
        public string $message,
        public array $orderNumber
    )
    {}

    public static function fromResponse(array $response){
        if(!isset($response["MessageModelList"]) || empty($response["MessageModelList"]) || !isset($response["MessageModelList"]["message"])){
            throw new Exception("楽天注文確認に失敗しました。必須パラメータがありません。");
        }

        $body = $response["MessageModelList"];

        return new ComfirmOrderResponse(
            $body["message"],
            array_map(fn($n)=>(new RakutenOrderNumber($n)),$body["orderNumber"])
        );
    }
}
