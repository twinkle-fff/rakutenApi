<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;
readonly class Orderer extends BaseResponseDto{
    protected function __construct(
        public string $zipCode1,
        public string $zipCode2,
        public string $prefecture,
        public string $city,
        public string $subAddress,
        public string $familyName,
        public string $firstName,
        public ?string $familyNameKana,
        public ?string $firstNameKana,
        public ?string $phoneNumber1,
        public ?string $phoneNumber2,
        public ?string $phoneNumber3,
        public ?string $emailAddress,
        public ?string $sex,
        public ?int $birthYear,
        public ?int $birthMonth,
        public ?int $birthDay,
    )
    {}
}
