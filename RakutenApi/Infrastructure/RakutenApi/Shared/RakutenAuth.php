<?php

namespace RakutenApi\Infrastructure\RakutenApi\Shared;

use RakutenApi\Util\EnvLoader\Envloader;
use RuntimeException;

/**
 * 楽天 API 認証情報を生成するクラス。
 *
 * - RAKUTEN_SERVICE_SECRET と RAKUTEN_LICENSE_KEY を .env からロード
 * - "ESA: {base64(SECRET:LICENSE_KEY)}" 形式のトークンを生成する
 * - 認証文字列は遅延生成（初回アクセス時に作成）
 */
class RakutenAuth
{
    private const string RAKUTEN_SECRET_ENV_KEY  = 'RAKUTEN_SERVICE_SECRET';
    private const string RAKUTEN_LICENSE_ENV_KEY = 'RAKUTEN_LICENSE_KEY';

    private ?string $rakutenServiceSecret = null;
    private ?string $rakutenLicenseKey    = null;
    private ?string $rakutenAuth          = null;

    /**
     * @param string|null $envFileName 読み込む .env ファイル名
     * @param string|null $envFilePath .env ファイルのパス
     *
     * @throws RuntimeException 認証情報が不足している場合
     */
    public function __construct(
        ?string $envFileName = null,
        ?string $envFilePath = null,
    ) {
        $this->loadEnv($envFileName, $envFilePath);
    }

    /**
     * 認証文字列 "ESA: xxxx" を返す。
     * 初回アクセス時に生成される。
     *
     * @return string
     * @throws RuntimeException
     */
    public function rakutenAuth(): string
    {
        if ($this->rakutenAuth === null) {
            $this->rakutenAuth = $this->generateAuth();
        }

        return $this->rakutenAuth;
    }

    /**
     * .env を読み込み、楽天 API のキーを取得する。
     *
     * @throws RuntimeException
     */
    private function loadEnv(?string $envFileName, ?string $envFilePath): void
    {
        $this->rakutenServiceSecret = Envloader::getEnv(
            self::RAKUTEN_SECRET_ENV_KEY,
            $envFileName,
            $envFilePath
        );

        $this->rakutenLicenseKey = Envloader::getEnv(
            self::RAKUTEN_LICENSE_ENV_KEY,
            $envFileName,
            $envFilePath
        );

        if (!$this->rakutenServiceSecret || !$this->rakutenLicenseKey) {
            throw new RuntimeException("楽天API認証情報の読み込みに失敗しました。");
        }
    }

    /**
     * "ESA: {base64(secret:license)}" 形式の文字列を生成する。
     *
     * @return string
     */
    private function generateAuth(): string
    {
        $raw  = "{$this->rakutenServiceSecret}:{$this->rakutenLicenseKey}";
        $code = base64_encode($raw);
        return "ESA: {$code}";
    }
}
