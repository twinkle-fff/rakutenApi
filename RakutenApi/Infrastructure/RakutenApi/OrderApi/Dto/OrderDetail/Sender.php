<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天注文詳細API：発送元（送り主）情報 DTO
 *
 * 注文における発送元住所・氏名・電話番号などの情報を保持します。
 * BaseResponseDto により、APIレスポンス配列から自動でマッピング・型変換されます。
 *
 * 使用例：
 *     $sender = Sender::fromResponse($response['sender']);
 */
readonly class Sender extends BaseResponseDto
{
    /**
     * @param string      $zipCode1          郵便番号（前半3桁）
     * @param string      $zipCode2          郵便番号（後半4桁）
     * @param string      $prefecture        都道府県
     * @param string      $city              市区町村
     * @param string      $subAddress        丁目・番地・建物名
     * @param string      $familyName        姓
     * @param string|null $firstName         名（null の場合あり）
     * @param string|null $familyNameKana    姓（カナ）
     * @param string|null $firstNameKana     名（カナ）
     * @param string|null $phoneNumber1      電話番号1（市外局番）
     * @param string|null $phoneNumber2      電話番号2（市内局番）
     * @param string|null $phoneNumber3      電話番号3（加入者番号）
     * @param int         $isolatedIslandFlag 離島フラグ（0/1）
     */
    protected function __construct(
        public string $zipCode1,
        public string $zipCode2,
        public string $prefecture,
        public string $city,
        public string $subAddress,
        public string $familyName,
        public ?string $firstName,
        public ?string $familyNameKana,
        public ?string $firstNameKana,
        public ?string $phoneNumber1,
        public ?string $phoneNumber2,
        public ?string $phoneNumber3,
        public int $isolatedIslandFlag
    ) {}
}
