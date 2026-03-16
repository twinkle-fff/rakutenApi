<?php


use RakutenApi\Infrastructure\RakutenApi\ItemApi\ItemApi;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail\Order;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\SearchOrder\SearchOrderParams;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Enum\OrderDateType;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\OrderApi;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;

require_once __DIR__."/../vendor/autoload.php";

$itemApi = new ItemApi();

$res = $itemApi->streamAllItems();

foreach($res as $r){
    var_dump($r);
    die();
}
