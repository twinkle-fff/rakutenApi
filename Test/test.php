<?php


use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail\Order;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\SearchOrder\SearchOrderParams;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Enum\OrderDateType;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\OrderApi;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;

require_once __DIR__."/../vendor/autoload.php";

$orderApi = new OrderApi();

$on = new RakutenOrderNumber("406156-20251128-0302141914");
$res = $orderApi->comfirmOrder([$on]);

var_dump($res);
