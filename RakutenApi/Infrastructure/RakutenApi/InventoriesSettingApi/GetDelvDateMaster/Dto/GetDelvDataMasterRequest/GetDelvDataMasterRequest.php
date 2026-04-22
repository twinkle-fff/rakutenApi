<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDataMasterRequest;

/**
 * 在庫設定API（GetDelvDateMaster）用リクエストDTO
 *
 * 配送日設定（delvdateNumber）を指定して、
 * 楽天RMSの配送日マスタを取得するためのパラメータを保持する。
 *
 * 不変オブジェクト（immutable）として設計されており、
 * 値の変更は新しいインスタンスを返すことで表現する。
 */
readonly class GetDelvDataMasterRequest{

    /**
     * @param string|null $delvdateNumber 配送日番号（任意）
     */
    public function __construct(
        public ?string $delvdateNumber = null
    )
    {}

    /**
     * 配送日番号からインスタンスを生成する
     *
     * @param string|null $delvdateNumber 配送日番号
     * @return self
     */
    public static function fromString(?string $delvdateNumber): GetDelvDataMasterRequest{
        return new self($delvdateNumber);
    }

    /**
     * 空のリクエストを生成する
     *
     * 配送日番号を指定しない場合に使用する
     *
     * @return self
     */
    public static function empty(): GetDelvDataMasterRequest{
        return new self();
    }

    /**
     * APIリクエスト用の配列に変換する
     *
     * @return array{delvdateNumber: string|null}
     */
    public function toArray(): array{
        return [
            "delvdateNumber" => $this->delvdateNumber
        ];
    }

    /**
     * 配送日番号を変更した新しいインスタンスを生成する
     *
     * immutableのため、既存インスタンスは変更されない
     *
     * @param string|null $delvdateNumber 配送日番号
     * @return self
     */
    public function setDelvdateNumber(?string $delvdateNumber): GetDelvDataMasterRequest{
        return new self($delvdateNumber);
    }
}
