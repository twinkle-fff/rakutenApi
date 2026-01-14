<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesApi\Dto\Request;

use ApiDto\BaseRequestDto\BaseRequestDto;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\Dto\Request\OperationLeadTime\OperationLeadTime;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\Enum\Mode;

final readonly class UpsertVariantRequest extends BaseRequestDto{


    /**
     * Summary of __construct
     * @param Mode $mode
     * @param int $quantity
     * @param ?OperationLeadTime $operationLeadTime
     * @param ?int[] $shipFromIds
     */
    public function __construct(
        public Mode $mode = Mode::ABSOLUTE,
        public int $quantity = 500,
        public ?OperationLeadTime $operationLeadTime = null,
        public ?array $shipFromIds = null
    )
    {}
}

