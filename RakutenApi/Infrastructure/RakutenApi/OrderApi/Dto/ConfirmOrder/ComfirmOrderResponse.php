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
        $body = $response["MessageModelList"][0];

        return new ComfirmOrderResponse(
            $body["message"],
            array_map(fn($n)=>(new RakutenOrderNumber($n)),$body["orderNumber"])
        );
    }
}
