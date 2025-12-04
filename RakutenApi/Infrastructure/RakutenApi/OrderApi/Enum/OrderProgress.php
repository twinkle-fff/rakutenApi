<?php
declare(strict_types=1);

namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Enum;

use Exception;

/**
 * 楽天注文ステータスを正規化する Enum。
 *
 * 楽天APIの orderProgressList で返却される注文進行状況コード（100〜900）
 * をアプリケーション内で扱いやすい Enum として定義。
 *
 * コードとラベルの対応は以下の通り：
 *  100: 注文確認待ち
 *  200: 楽天処理中
 *  300: 発送待ち
 *  400: 変更確定待ち
 *  500: 発送済
 *  600: 支払手続き中
 *  700: 支払手続き済
 *  800: キャンセル確定待ち
 *  900: キャンセル確定
 */
enum OrderProgress: int
{
    /** 注文確認待ち (100) */
    case PENDING = 100;

    /** 楽天処理中 (200) */
    case RAKUTEN_PROCESSING = 200;

    /** 発送待ち (300) */
    case TO_SHIP = 300;

    /** 変更確定待ち (400) */
    case CHANGE_PENDING = 400;

    /** 発送済 (500) */
    case SHIPPED = 500;

    /** 支払手続き中 (600) */
    case TO_BE_PAID = 600;

    /** 支払手続き済 (700) */
    case PAID = 700;

    /** キャンセル確定待ち (800) */
    case TO_BE_CANCELLED = 800;

    /** キャンセル確定 (900) */
    case CANCELLED = 900;

    /**
     * ステータスコード → 日本語ラベル の対応表を返す内部メソッド。
     *
     * @return array<int, string> [value => label]
     */
    private static function labels(): array
    {
        return [
            100 => "注文確認待ち",
            200 => "楽天処理中",
            300 => "発送待ち",
            400 => "変更確定待ち",
            500 => "発送済",
            600 => "支払い手続き中",
            700 => "支払い手続き済",
            800 => "キャンセル確定待ち",
            900 => "キャンセル確定",
        ];
    }

    /**
     * Enum 値に対応する日本語ラベルを取得する。
     *
     * @throws Exception ラベルが定義されていない場合
     * @return string 日本語ラベル
     */
    public function label(): string
    {
        return self::labels()[$this->value]
            ?? throw new Exception("楽天注文状況の正規化に失敗しました。{$this->value} の注文状況に対応するラベルがありません。");
    }

    /**
     * 日本語ラベルから Enum を逆引きする。
     *
     * @param string $inputLabel 楽天API上の日本語ステータス（例：'発送待ち'）
     *
     * @throws Exception 未定義のラベルが指定された場合
     * @return self 対応する Enum
     */
    public static function fromLabel(string $inputLabel): self
    {
        foreach (self::labels() as $value => $label) {
            if ($label === $inputLabel) {
                return self::tryFrom($value)
                    ?? throw new Exception("楽天注文状況の正規化に失敗しました。{$inputLabel} に対応するEnum変換に失敗しました。");
            }
        }

        throw new Exception("楽天注文状況の正規化に失敗しました。{$inputLabel} は定義されていない注文状況です。");
    }
}
