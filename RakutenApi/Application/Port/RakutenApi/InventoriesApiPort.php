<?php
namespace RakutenApi\Application\Port\RakutenApi;

use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\Dto\Request\UpsertVariantRequest;

interface InventoriesApiPort{
    public function upsertVariants(string $manageNumber, string $sku, array|UpsertVariantRequest $upsertVariantRequest):bool;
}
