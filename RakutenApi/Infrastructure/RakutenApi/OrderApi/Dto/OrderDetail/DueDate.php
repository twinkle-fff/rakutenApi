<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

readonly class DueDate extends BaseResponseDto
{
    /**
     * @param int $dueDateType 期限日の種別ID
     * @param DateTimeInterface $dueDate 期限日（DateTime オブジェクト）
     */
    protected function __construct(
        public int $dueDateType,
        public DateTime $dueDate
    ) {}
}
