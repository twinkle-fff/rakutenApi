<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\OperationLeadTimeBizModel;

use ApiDto\BaseResponseDto\BaseResponseDto;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\OperationLeadTimeBizModel\OperationLeadTimeList\OperationLeadTimeList;

readonly class OperationLeadTimeBizModel extends BaseResponseDto
{
    public function __construct(
        public ?OperationLeadTimeList $operationLeadTimeList
    ) {}
}
