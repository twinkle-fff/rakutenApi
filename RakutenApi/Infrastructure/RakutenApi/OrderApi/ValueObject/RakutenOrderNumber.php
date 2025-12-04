<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject;

use InvalidArgumentException;

/**
 * 楽天注文番号を表すValueObject。
 *
 * 楽天注文番号の正式フォーマット（`6桁-8桁-10桁`）に従って
 * バリデーションを行い、安全に扱えるようにする。
 *
 * 例: 123456-20241127-0000123456
 */
readonly class RakutenOrderNumber
{
    /**
     * @var string 注文番号（フォーマット済）
     */
    private string $orderNumber;

    /**
     * コンストラクタ
     *
     * @param string $orderNumber 値として渡される楽天注文番号。
     *                            フォーマットが不正な場合は例外を投げる。
     *
     * @throws InvalidArgumentException バリデーションに失敗した場合
     */
    public function __construct(string $orderNumber)
    {
        $this->validate($orderNumber);
        $this->orderNumber = $orderNumber;
    }

    /**
     * 楽天注文番号の形式をチェックする。
     *
     * フォーマット:
     *  - 6桁の数字
     *  - ハイフン
     *  - 8桁の数字
     *  - ハイフン
     *  - 10桁の数字
     *
     * 正規表現: `/^\d{6}-\d{8}-\d{10}$/`
     *
     * @param string $orderNumber チェック対象の注文番号
     *
     * @throws InvalidArgumentException 不正フォーマットの場合
     */
    private function validate(string $orderNumber): void
    {
        $orderNumberRegex = "/^\d{6}-\d{8}-\d{10}$/";

        if (!preg_match($orderNumberRegex, $orderNumber)) {
            throw new InvalidArgumentException(
                "楽天注文番号のバリデーションに失敗しました。{$orderNumber}は正しい形式ではありません。"
            );
        }
    }

    /**
     * 値オブジェクトが保持する注文番号を返す。
     *
     * @return string 注文番号
     */
    public function getValue(): string
    {
        return $this->orderNumber;
    }
}
