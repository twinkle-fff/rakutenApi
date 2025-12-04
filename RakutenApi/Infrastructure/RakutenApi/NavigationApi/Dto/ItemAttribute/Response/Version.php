<?php
namespace RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute\Response;

use DateTime;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * Class Version
 *
 * ナビゲーション API（itemAttribute）レスポンスに含まれる
 * 「属性マスタのバージョン情報」を表す DTO。
 *
 * 楽天商品属性（項目属性）の更新監視や、
 * キャッシュのリフレッシュ判断などで使用する。
 *
 * ### 主な役割
 * - `id` : 属性定義のバージョン番号
 * - `fixedAt` : 属性定義が固定された日時（更新日時）
 *
 * ### 使用例
 * ```php
 * $version = new Version(
 *     id: 1203,
 *     fixedAt: new DateTime('2024-03-10T12:00:00+09:00')
 * );
 * ```
 *
 * @property-read int      $id        属性定義のバージョン番号
 * @property-read DateTime $fixedAt   バージョンが確定した日時（日本時間）
 */
readonly class Version extends BaseResponseDto
{
    /**
     * @param int      $id       属性マスタのバージョン番号
     * @param DateTime $fixedAt  属性マスタが固定された日時
     */
    public function __construct(
        public int $id,
        public DateTime $fixedAt
    ) {}
}
