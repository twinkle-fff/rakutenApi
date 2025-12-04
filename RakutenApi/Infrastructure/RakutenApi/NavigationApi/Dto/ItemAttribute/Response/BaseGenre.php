<?php
namespace RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute\Response;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * Class BaseGenre
 *
 * 楽天市場ナビゲーション API（itemAttribute）で返却される
 * 「ジャンル情報」を表す基本 DTO。
 *
 * 楽天のジャンル体系は階層（レベル）構造になっており、
 * 商品登録画面ではジャンルによって属性入力の必須/任意や
 * 下層ジャンルの存在などが変化するため、
 * 本 DTO はそれらのメタ情報を保持する。
 *
 * ### 主なフィールド
 *
 * - **genreId**
 *     ジャンルを識別するユニークな ID。
 *
 * - **genreIdPath**
 *     ルートからこのジャンルに至るまでのジャンル ID の配列。
 *     例）`[100, 200, 345]` のように階層構造を表す。
 *
 * - **nameJa**
 *     ジャンル名（日本語）。
 *
 * - **nameJaPath**
 *     パンくず形式の日本語ジャンル名。
 *     例）「食品 > 麺類 > ラーメン」
 *
 * - **level**
 *     ジャンル階層の深さ（0〜）。
 *     大分類：0、中分類：1、… のように定義される。
 *
 * - **lowest**
 *     このジャンルが最下層ジャンルかどうか。
 *     true の場合、商品登録時にこのジャンルで確定できる。
 *
 * - **properties（GenreProperty）**
 *     このジャンルにおける属性入力の制御情報（必須かどうか等）。
 *
 *
 * ### 使用例
 *
 * ```php
 * $genre = new BaseGenre(
 *     genreId: 12345,
 *     genreIdPath: [100, 200, 12345],
 *     nameJa: "冷蔵食品",
 *     nameJaPath: "食品 > 惣菜 > 冷蔵食品",
 *     level: 2,
 *     lowest: true,
 *     properties: new GenreProperty(true)
 * );
 *
 * if ($genre->lowest) {
 *     // このジャンルは最下層 → 商品登録が可能
 * }
 * ```
 *
 * @property-read int            $genreId      ジャンル ID
 * @property-read int[]          $genreIdPath  ジャンル階層の ID パス
 * @property-read string         $nameJa       日本語ジャンル名
 * @property-read string         $nameJaPath   日本語ジャンル名のパス（パンくず）
 * @property-read int            $level        ジャンル階層レベル
 * @property-read bool           $lowest       最下層ジャンルかどうか
 * @property-read GenreProperty  $properties   属性必須制御などの追加情報
 */
readonly class BaseGenre extends BaseResponseDto
{
    /**
     * @param int            $genreId
     * @param int[]          $genreIdPath
     * @param string         $nameJa
     * @param string         $nameJaPath
     * @param int            $level
     * @param bool           $lowest
     * @param GenreProperty  $properties
     */
    public function __construct(
        public int $genreId,
        public array $genreIdPath,
        public string $nameJa,
        public string $nameJaPath,
        public int $level,
        public bool $lowest,
        public GenreProperty $properties
    ) {}
}
