<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天注文詳細API：コンビニ受取情報 DTO
 *
 * コンビニ受取配送時の店舗情報や営業時間などを保持します。
 * BaseResponseDto を継承することで、APIレスポンス配列から
 * 自動的に型変換・必須チェックを行うことができます。
 *
 * 例：
 * $dto = DeliveryCVS::fromResponse($response['deliveryCvs']);
 */
readonly class DeliveryCVS extends BaseResponseDto
{
    /**
     * @param int|null    $cvsCode          コンビニコード
     * @param string|null $storeGenreCode   店舗種別コード（例：SE、LF など）
     * @param string|null $storeCode        店舗コード
     * @param string|null $storeName        店舗名
     * @param string|null $storeZip         店舗郵便番号
     * @param string|null $storePrefecture  都道府県名
     * @param string|null $storeAddress     店舗住所
     * @param string|null $areaCode         エリアコード
     * @param string|null $depo             受付デポコード
     * @param string|null $openTime         営業開始時刻（文字列）
     * @param string|null $closeTime        営業終了時刻（文字列）
     * @param string|null $cvsRemarks       備考・注意事項
     */
    protected function __construct(
        public ?int $cvsCode,
        public ?string $storeGenreCode,
        public ?string $storeCode,
        public ?string $storeName,
        public ?string $storeZip,
        public ?string $storePrefecture,
        public ?string $storeAddress,
        public ?string $areaCode,
        public ?string $depo,
        public ?string $openTime,
        public ?string $closeTime,
        public ?string $cvsRemarks
    ) {}
}
