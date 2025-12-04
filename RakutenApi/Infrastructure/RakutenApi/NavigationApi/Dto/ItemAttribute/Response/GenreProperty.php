<?php
namespace RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute\Response;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * Class GenreProperty
 *
 * ナビゲーション API（itemAttribute）における
 * 「ジャンル単位の属性設定情報」を表す DTO。
 *
 * 楽天市場のジャンルによっては、商品登録時に
 * 属性入力が必須かどうかが異なるため、
 * そのフラグを判定する目的で使用される。
 *
 * ### 主な役割
 * - `itemRegisterFlg` :
 *     商品登録時にこのジャンルで属性入力が必須かどうかを示すフラグ
 *     - `true`  → 属性入力が必要
 *     - `false` → 属性入力が不要
 *
 * ### 使用例
 * ```php
 * $property = new GenreProperty(
 *     itemRegisterFlg: true
 * );
 *
 * if ($property->itemRegisterFlg) {
 *     // 該当ジャンルでは属性入力が必要
 * }
 * ```
 *
 * @property-read bool $itemRegisterFlg 商品登録時に属性入力が必須かどうか
 */
readonly class GenreProperty extends BaseResponseDto
{
    /**
     * @param bool $itemRegisterFlg 商品登録において属性入力が必須かどうか
     */
    public function __construct(
        public bool $itemRegisterFlg
    ) {}
}
