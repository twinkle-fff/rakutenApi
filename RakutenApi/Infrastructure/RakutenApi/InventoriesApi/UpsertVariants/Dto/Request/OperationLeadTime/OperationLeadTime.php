<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesApi\Dto\Request\OperationLeadTime;

use ApiDto\BaseRequestDto\BaseRequestDto;

final readonly class OperationLeadTime extends BaseRequestDto{
    public function __construct(
        public ?int $normalDeliveryTimeId,
        public ?int $backOrderDeliveryTimeId,
    )
    {}
}
