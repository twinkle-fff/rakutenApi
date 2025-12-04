<?php

namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Enum;

/**
 * 楽天注文に紐づく日付種別 Enum。
 *
 * 1: 注文日
 * 2: 注文確認日
 * 3: 注文確定日
 * 4: 発送日
 * 5: 発送完了報告日
 * 6: 決済確定日
 */
enum OrderDateType: int
{
    case ORDER_DATE = 1;
    case CONFIRMATION_DATE = 2;
    case FIXED_DATE = 3;
    case SHIPPING_DATE = 4;
    case SHIPPING_COMPLETED_DATE = 5;
    case SETTLEMENT_DATE = 6;

    /**
     * ラベル配列（定義順）
     *
     * @return array<int, string>
     */
    public static function labels(): array
    {
        return [
            self::ORDER_DATE->value               => '注文日',
            self::CONFIRMATION_DATE->value        => '注文確認日',
            self::FIXED_DATE->value               => '注文確定日',
            self::SHIPPING_DATE->value            => '発送日',
            self::SHIPPING_COMPLETED_DATE->value  => '発送完了報告日',
            self::SETTLEMENT_DATE->value          => '決済確定日',
        ];
    }

    /**
     * 個別の Enum インスタンスからラベルを取得
     */
    public function label(): string
    {
        return self::labels()[$this->value];
    }

    /**
     * ラベル文字列から Enum を逆引きする
     *
     * @throws \InvalidArgumentException
     */
    public static function fromLabel(string $label): self
    {
        $labels = self::labels();

        $value = array_search($label, $labels, true);

        if ($value === false) {
            throw new \InvalidArgumentException("OrderDateType::fromLabel: '{$label}' に該当する定義がありません。");
        }

        return self::from($value);
    }
}
