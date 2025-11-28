<?php

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail\Order;

require_once __DIR__."/../vendor/autoload.php";

$json = file_get_contents(__DIR__."/../tmp.json");
$data = json_decode($json,true);
if(json_last_error() != JSON_ERROR_NONE){
    die(json_last_error_msg());
}

$ob = $data["OrderModelList"][0];
$obj = Order::fromResponse($ob);
$size = strlen(serialize($obj));
echo("object size is {$size}".PHP_EOL);
