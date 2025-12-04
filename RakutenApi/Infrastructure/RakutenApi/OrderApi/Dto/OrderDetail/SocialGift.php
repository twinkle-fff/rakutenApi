<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use DateTime;
use Exception;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;
use ReflectionClass;

/**
 * 楽天注文詳細APIにおけるソーシャルギフト情報 DTO
 *
 * ・ソーシャルギフト管理番号
 * ・入力期限
 * ・入力状態フラグ
 * ・入力完了日時
 * ・受取者メールアドレス
 * を保持する。
 */
readonly class SocialGift extends BaseResponseDto
{
    /**
     * @param string    $sgMngNumber           ソーシャルギフト管理番号
     * @param DateTime  $inputDueDate          ギフト入力期限日時
     * @param int       $inputFlag             入力状態フラグ（0/1）
     * @param DateTime  $inputCompDatetime     入力完了日時
     * @param string    $receiverEmailAddress  受取者メールアドレス
     */
    protected function __construct(
        public string $sgMngNumber,
        public DateTime $inputDueDate,
        public int $inputFlag,
        public DateTime $inputCompDatetime,
        public string $receiverEmailAddress
    ) {}
}
