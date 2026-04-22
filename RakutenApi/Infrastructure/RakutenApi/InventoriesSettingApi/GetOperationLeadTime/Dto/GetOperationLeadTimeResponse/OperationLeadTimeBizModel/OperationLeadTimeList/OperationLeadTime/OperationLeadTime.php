<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\OperationLeadTimeBizModel\OperationLeadTimeList\OperationLeadTime;

use ApiDto\BaseResponseDto\BaseResponseDto;

readonly class OperationLeadTime extends BaseResponseDto
{
    public bool $inStockDefaultFlag;
    public bool $outOfStockDefaultFlag;

    public function __construct(
        public ?string $operationLeadTimeId,
        public ?string $name,
        public ?string $numberOfDays,
        ?int $inStockDefaultFlag,
        ?int $outOfStockDefaultFlag
    ) {
        $this->inStockDefaultFlag = (int)$inStockDefaultFlag === 1;
        $this->outOfStockDefaultFlag = (int)$outOfStockDefaultFlag === 1;
    }
}
