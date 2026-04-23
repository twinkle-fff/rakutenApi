<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\ResultMessageModelList\ResultMessage;

use ApiDto\BaseResponseDto\BaseResponseDto;

readonly class ResultMessage extends BaseResponseDto{
    public function __construct(
        public string $code,
        public string $message,
    )
    {}
}
