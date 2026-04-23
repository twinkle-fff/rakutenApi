<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\OperationLeadTimeBizModel\OperationLeadTimeList;

use ApiDto\BaseResponseDto\BaseResponseDto;

readonly class OperationLeadTimeList extends BaseResponseDto
{
    /**
     * @var list<RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\OperationLeadTimeBizModel\OperationLeadTimeList\OperationLeadTime\OperationLeadTime>
     */
    public array $operationLeadTime;

    public function __construct(array $operationLeadTime)
    {
        if (!array_is_list($operationLeadTime)) {
            $operationLeadTime = [$operationLeadTime];
        }

        $this->operationLeadTime = $operationLeadTime;
    }
}
