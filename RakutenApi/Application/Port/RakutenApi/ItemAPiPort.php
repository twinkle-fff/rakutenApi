<?php
namespace RakutenApi\Application\Port\RakutenApi;

use RakutenApi\Domain\ItemSearch\ValueObject\ItemSearchParams;

interface ItemAPiPort{
    public function searchItems(
        array|ItemSearchParams|null $params = null
    ):array;

}
