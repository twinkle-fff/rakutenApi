<?php

namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\NotifyShipment;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Enum\DeliveryCompany;

/**
 * 出荷通知用 DTO（楽天API NotifyShipment 用）
 *
 * - 配送業者：DeliveryCompany Enum
 * - 伝票番号：string
 * - 出荷日　：ISO形式 "Y-m-d\TH:i:s+0900"
 * - 削除フラグ（willDelete）：0 / 1
 */
readonly class Shipment
{
    private const WILL_DELETE = 1;
    private const NOT_DELETE  = 0;

    /** @var DeliveryCompany 配送会社 */
    private DeliveryCompany $deliveryCompany;

    /** @var string 伝票番号 */
    private string $shippingNumber;

    /** @var string 出荷日（ISOフォーマット） */
    private string $shippingDate;

    /** @var int 削除フラグ（0 or 1） */
    private int $willDelete;

    /**
     * コンストラクタ
     *
     * @param string|int|DeliveryCompany    $deliveryCompany 配送会社（コード / 日本語ラベル / Enum）
     * @param string                        $shippingNumber  伝票番号
     * @param string|int|DateTimeInterface  $shippingDate    出荷日
     * @param bool|int|null                 $willDelete      削除フラグ（true/false または 0/1）
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        string|int|DeliveryCompany $deliveryCompany,
        string $shippingNumber,
        string|int|DateTimeInterface $shippingDate,
        bool|int|null $willDelete = null
    ) {
        $this->deliveryCompany = $this->normalizeDeliveryCompany($deliveryCompany);
        $this->shippingNumber  = $shippingNumber;
        $this->shippingDate    = $this->castISO($shippingDate);
        $this->willDelete      = $this->normalizeWillDelete($willDelete);
    }

    /**
     * 配送会社を DeliveryCompany Enum に正規化する。
     *
     * @param string|int|DeliveryCompany $deliveryCompany
     * @return DeliveryCompany
     *
     * @throws InvalidArgumentException
     */
    private function normalizeDeliveryCompany(string|int|DeliveryCompany $deliveryCompany): DeliveryCompany
    {
        if ($deliveryCompany instanceof DeliveryCompany) {
            return $deliveryCompany;
        }

        if (is_int($deliveryCompany)) {
            $enum = DeliveryCompany::tryFrom($deliveryCompany);
            if ($enum === null) {
                throw new InvalidArgumentException("不正な配送会社コード: {$deliveryCompany}");
            }
            return $enum;
        }

        if (is_string($deliveryCompany)) {
            return DeliveryCompany::fromLabel($deliveryCompany);
        }

        throw new InvalidArgumentException("配送会社の解析に失敗しました");
    }

    /**
     * 与えられた日時を ISO 形式 "Y-m-d\TH:i:s+0900" に正規化する。
     *
     * @param string|int|DateTimeInterface $datetime
     * @return string
     *
     * @throws InvalidArgumentException
     */
    private function castISO(string|int|DateTimeInterface $datetime): string
    {
        if (is_int($datetime)) {
            $datetime = new DateTimeImmutable('@' . $datetime);
        } elseif (is_string($datetime)) {
            try {
                $datetime = new DateTimeImmutable($datetime);
            } catch (Exception) {
                throw new InvalidArgumentException("入力された日時形式が不正です: '{$datetime}'");
            }
        } elseif ($datetime instanceof DateTimeInterface) {
            $datetime = new DateTimeImmutable($datetime->format('c'));
        }

        return $datetime
            ->setTimezone(new \DateTimeZone('Asia/Tokyo'))
            ->format('Y-m-d\TH:i:s+0900');
    }

    /**
     * 削除フラグを int (0/1) に正規化する。
     *
     * @param bool|int|null $willDelete
     * @return int
     *
     * @throws InvalidArgumentException
     */
    private function normalizeWillDelete(bool|int|null $willDelete): int
    {
        if ($willDelete === null) {
            return self::NOT_DELETE;
        }

        if (is_bool($willDelete)) {
            return $willDelete ? self::WILL_DELETE : self::NOT_DELETE;
        }

        if (is_int($willDelete)) {
            if ($willDelete === 0 || $willDelete === 1) {
                return $willDelete;
            }
            throw new InvalidArgumentException("削除フラグ {$willDelete} は不正な値です。0/1のみ有効です。");
        }

        throw new InvalidArgumentException("削除フラグの形式が不正です。");
    }

    /**
     * 配列化（API送信用）
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'deliveryCompany' => $this->deliveryCompany->value,
            'shippingNumber'  => $this->shippingNumber,
            'shippingDate'    => $this->shippingDate,
            'willDelete'      => $this->willDelete,
        ];
    }

    /**
     * 配列から Shipment を生成する。
     *
     * @param array $data
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        try {
            return new self(
                $data['deliveryCompany'],
                $data['shippingNumber'],
                $data['shippingDate'],
                $data['willDelete'] ?? 0
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException(
                "発送情報の初期化に失敗しました: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }
}
