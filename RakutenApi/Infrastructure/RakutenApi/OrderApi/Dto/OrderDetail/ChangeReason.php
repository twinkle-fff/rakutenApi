<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use DateTime;
use Exception;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;
use ReflectionClass;

/**
 * 注文変更理由・変更日時情報のDTO
 */
readonly class ChangeReason extends BaseResponseDto
{
    /**
     * @param int $changeId 変更ID
     * @param int|null $changeType 変更区分
     * @param int|null $changeTypeDetail 変更区分詳細
     * @param int|null $changeReason 変更理由
     * @param int|null $changeReasonDetail 変更理由詳細
     * @param DateTime|null $changeApplyDatetime 変更適用日時
     * @param DateTime|null $changeFixDatetime 変更確定日時
     * @param DateTime|null $changeCmplDatetime 変更完了日時
     */
    protected function __construct(
        public int $changeId,
        public ?int $changeType,
        public ?int $changeTypeDetail,
        public ?int $changeReason,
        public ?int $changeReasonDetail,
        public ?DateTime $changeApplyDatetime,
        public ?DateTime $changeFixDatetime,
        public ?DateTime $changeCmplDatetime
    ) {}
}
