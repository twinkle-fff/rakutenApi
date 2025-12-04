<?php
namespace RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute\Response;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * Class Genre
 *
 * 楽天ナビゲーション API（itemAttribute）における
 * 「ジャンル情報 + 属性情報（attributes）」の統合 DTO。
 *
 * 楽天の商品登録仕様では、
 * 商品に対してジャンル（genre）を設定すると、
 * そのジャンルに紐づく「入力必須項目」「推奨項目」「属性（attributes）」が
 * すべて返却される。
 *
 * この Genre クラスは、ジャンル階層構造（親・兄弟・子ジャンル）と
 * そのジャンルが持つ属性仕様（Attributes DTO）を保持する。
 *
 * ---------------------------------------
 * ▼ 主なフィールド
 * ---------------------------------------
 *
 * ■ ジャンル基本情報
 * - **genreId**
 *      ジャンル ID（最深層 or 中間層）
 *
 * - **genreIdPath[]**
 *      上位階層のジャンル ID の一覧
 *      例：`[0, 100, 200, 230]`
 *
 * - **nameJa**
 *      ジャンル名（日本語）
 *
 * - **nameJaPath[]**
 *      上位階層のジャンル名一覧
 *      例：`["食品", "菓子", "チョコレート"]`
 *
 * - **level**
 *      階層レベル（0＝トップ）
 *
 * - **lowest**
 *      最下層ジャンルであるか？
 *
 * ■ ジャンル属性情報
 * - **properties (GenreProperty DTO)**
 *      「ジャンルに商品登録可能か？」などの条件を保持
 *
 * ■ 階層構造
 * - **ancestors[] : BaseGenre[]**
 *      祖先ジャンル
 *
 * - **siblings[] : BaseGenre[]**
 *      同階層の他ジャンル
 *
 * - **children[] : BaseGenre[]**
 *      子ジャンル（下位階層）
 *
 * ■ attributes : Attributes DTO
 *      そのジャンルに紐づく属性仕様一覧
 *      例：容量、カラー、メーカー型番などの入力仕様
 *
 * ---------------------------------------
 * ▼ 使用例
 * ---------------------------------------
 *
 * ```php
 * $genre = new Genre(
 *     genreId: 230,
 *     genreIdPath: [0, 100, 200, 230],
 *     nameJa: "チョコレート",
 *     nameJaPath: ["食品", "菓子", "チョコレート"],
 *     level: 3,
 *     lowest: true,
 *     properties: new GenreProperty(itemRegisterFlg: true),
 *     ancestors: [... BaseGenre ...],
 *     siblings: [... BaseGenre ...],
 *     children: [],
 *     attributes: new Attributes(...属性データ...)
 * );
 *
 * if ($genre->attributes->properties->rmsMandatoryFlg) {
 *     // このジャンルでは必須項目が存在する
 * }
 * ```
 *
 * ---------------------------------------
 *
 * @property-read int            $genreId
 * @property-read array          $genreIdPath
 * @property-read string         $nameJa
 * @property-read array          $nameJaPath
 * @property-read int            $level
 * @property-read bool           $lowest
 * @property-read GenreProperty  $properties
 * @property-read BaseGenre[]    $ancestors
 * @property-read BaseGenre[]    $siblings
 * @property-read BaseGenre[]    $children
 * @property-read Attributes[]    $attributes
 */
readonly class Genre extends BaseResponseDto
{
    /** @var array<string,class-string> 子 DTO のマップ */
    protected const array ARRAY_CHILD_MAP = [
        "ancestors" => BaseGenre::class,
        "siblings"  => BaseGenre::class,
        "children"  => BaseGenre::class,
        "attributes"=> Attributes::class
    ];

    public function __construct(
        public int $genreId,
        public array $genreIdPath,
        public string $nameJa,
        public array $nameJaPath,
        public int $level,
        public bool $lowest,
        public GenreProperty $properties,
        public ?array $ancestors,
        public ?array $siblings,
        public ?array $children,
        public array $attributes
    ) {}
}
