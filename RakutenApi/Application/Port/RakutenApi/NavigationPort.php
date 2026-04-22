<?php
namespace RakutenApi\Application\Port\RakutenApi;

use RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute\ItemAttributeResponse;

interface NavigationPort{
    public function getItemAttribute(int $genreId):ItemAttributeResponse;
}
