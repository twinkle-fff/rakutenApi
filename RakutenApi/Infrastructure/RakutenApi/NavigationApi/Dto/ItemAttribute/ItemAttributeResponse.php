<?php
namespace RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute;
require_once __DIR__."/../../../../../../vendor/autoload.php";
use RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute\Response\Genre;
use RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute\Response\Version;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * Class ItemAttributeResponse
 *
 * 楽天ナビゲーション API（/navigation/item/attribute）レスポンスの
 * ルート DTO。
 *
 * 楽天の商品登録における「ジャンル（genre）」に紐づく
 * ・必須属性
 * ・推奨属性
 * ・属性の入力仕様（制限・入力方式など）
 * をまとめて保持する。
 *
 * ---------------------------------------
 * ▼ レスポンス構造（RMS API仕様）
 * ---------------------------------------
 * {
 *   "version": {
 *       "id": 123,
 *       "fixedAt": "2024-03-10T00:00:00+0900"
 *   },
 *   "genre": {
 *       "genreId": 101349,
 *       "level": 3,
 *       "nameJa": "チョコレート",
 *       "properties": {...},
 *       "ancestors": [...],
 *       "siblings": [...],
 *       "children": [...],
 *       "attributes": [... 属性仕様 ...]
 *   }
 * }
 *
 * ---------------------------------------
 * ▼ プロパティ説明
 * ---------------------------------------
 *
 * ■ version（Version DTO）
 * - 属性データのバージョン番号
 * - データが更新された日時（fixedAt）
 * - 商品属性仕様のメンテナンスの判定に利用
 *
 * ■ genre（Genre DTO）
 * - ジャンル情報そのもの
 * - attributes[] にはそのジャンルで入力可能な項目（容量・カラー・型番 等）
 * - ancestors / siblings / children により階層構造も得られる
 *
 * ---------------------------------------
 * ▼ 使用例
 * ---------------------------------------
 *
 * ```php
 * $response = new ItemAttributeResponse(
 *     version: new Version(id: 12, fixedAt: new DateTime()),
 *     genre: $genreDto
 * );
 *
 * echo $response->genre->attributes[0]->nameJa;
 * ```
 *
 * @property-read Version $version  属性データのバージョン情報
 * @property-read Genre   $genre    ジャンルおよび属性仕様
 */
readonly class ItemAttributeResponse extends BaseResponseDto
{
    public function __construct(
        public Version $version,
        public Genre $genre,
    ) {}
}


if(basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])){
    $json = file_get_contents("/Library/WebServer/Documents/library/rakutenApi/tmpatt.json");
    $data = json_decode($json,true);
    $r = ItemAttributeResponse::fromResponse($data);
    echo json_encode($r,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
}
