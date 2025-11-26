<?php

namespace RakutenApi\Infrastructure\RakutenApi\Shared\ValueObject;

/**
 * 楽天 API のレスポンスステータスを表す ValueObject。
 *
 * 楽天 RMS・Ichiba API の仕様に基づき、
 * - 成功（2xx）
 * - レートリミット（429）
 * - サーバーエラー（5xx）
 * を分類し、成功判定と再試行判定を提供する。
 *
 * このクラスを使うことで、呼び出し側は HTTP ステータスコードの
 * 詳細判定を意識する必要がなくなる。
 *
 * 例:
 *     $status = RakutenResponseStatus::fromStatusCode($code);
 *     if ($status->willRetry()) { ... }
 *     if ($status->isSuccess()) { ... }
 *
 * @readonly
 */
readonly class RakutenResponseStatus
{
    /**
     * @param bool $isSuccess このレスポンスが成功(2xx)かどうか
     * @param bool $willRetry 再試行すべきエラーかどうか
     */
    private function __construct(
        private bool $isSuccess,
        private bool $willRetry
    ) {}

    /**
     * HTTPステータスコードから楽天API用のステータスオブジェクトを生成する。
     *
     * 判定ルール:
     * - 2xx → 成功 (isSuccess=true, willRetry=false)
     * - 429 → レートリミットのためリトライ推奨 (willRetry=true)
     * - 5xx → サーバーエラーのためリトライ推奨
     * - 上記以外の4xx → クライアントエラーのためリトライ不要
     *
     * @param int $statusCode HTTPステータスコード
     * @return self
     */
    public static function fromStatusCode(int $statusCode): self
    {
        // 2xx 成功
        if ($statusCode >= 200 && $statusCode < 300) {
            return new self(true, false);
        }

        // レートリミット
        if ($statusCode === 429) {
            return new self(false, true);
        }

        // サーバーエラー（RMSは頻出）
        if ($statusCode >= 500) {
            return new self(false, true);
        }

        // それ以外の 4xx → 失敗・リトライ不要
        return new self(false, false);
    }

    /**
     * このレスポンスが成功（HTTP 2xx）だったかどうか。
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * このレスポンスが再試行すべきエラーかどうか。
     * （429, 5xx が該当）
     *
     * @return bool
     */
    public function willRetry(): bool
    {
        return $this->willRetry;
    }
}
