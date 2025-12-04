<?php
namespace RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute\Response;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * Class Attributes
 *
 * 楽天市場ナビゲーション API（itemAttribute）で返却される
 * 「属性（attribute）」1 件分を表す DTO。
 *
 * 属性とは、ジャンルに紐づく「商品登録時に入力できる項目」
 * のことであり、「色」「サイズ」「容量」「賞味期限」など
 * ジャンルごとに異なる入力仕様を持つ。
 *
 * 本 DTO は、その属性の入力制約（数値範囲・文字数制限・日付形式など）
 * および RMS での必須・任意などのメタ情報を保持する。
 *
 * ### 主なフィールド概要
 *
 * - **id**
 *     属性 ID（楽天内部 ID）
 *
 * - **nameJa**
 *     日本語属性名（例：`カラー`、`サイズ`）
 *
 * - **dataType**
 *     入力種類
 *     例）`STRING`, `INTEGER`, `DECIMAL`, `DATE`, `SELECT` 等
 *
 * - **minLength / maxLength**
 *     dataType が STRING の場合の文字列入力制限
 *
 * - **minValue / maxValue**
 *     数値入力（INTEGER / DECIMAL）の範囲制限
 *
 * - **dateFormat**
 *     dataType が DATE の場合の入力形式
 *     例：`yyyyMMdd`
 *
 * - **unit**
 *     数値属性に付随する単位（例：`cm`, `kg`）
 *
 * - **subUnits**
 *     選択式属性の候補リスト（例：`["赤", "青", "黒"]`）
 *
 * - **properties (Properties DTO)**
 *     RMS における入力必須/推奨などの制御情報
 *
 *
 * ### 使用例
 *
 * ```php
 * $attr = new Attributes(
 *     id: 101,
 *     nameJa: "容量",
 *     dataType: "DECIMAL",
 *     minLength: null,
 *     maxLength: null,
 *     minValue: 0.1,
 *     maxValue: 5000,
 *     dateFormat: null,
 *     unit: "ml",
 *     subUnits: null,
 *     properties: new Properties(
 *         rmsMandatoryFlg: true,
 *         rmsMandatoryType: "mandatory",
 *         rmsMultiValueLimit: 1,
 *         rmsInputMethod: "textbox",
 *         rmsSkuUnifyFlg: false,
 *         rmsRecommend: false
 *     )
 * );
 *
 * if ($attr->properties->rmsMandatoryFlg) {
 *     // 商品登録時に必須入力
 * }
 * ```
 *
 * @property-read int        $id          属性 ID
 * @property-read string     $nameJa      属性名（日本語）
 * @property-read string     $dataType    入力タイプ
 * @property-read int|null   $minLength   STRING の最小文字数
 * @property-read int|null   $maxLength   STRING の最大文字数
 * @property-read float|null $minValue    数値入力の最小値
 * @property-read float|null $maxValue    数値入力の最大値
 * @property-read string|null $dateFormat DATE 入力時のフォーマット
 * @property-read string|null $unit       数値属性の単位
 * @property-read array|null  $subUnits   選択肢一覧
 * @property-read Properties  $properties 属性の必須・推奨情報
 */
readonly class Attributes extends BaseResponseDto
{
    public function __construct(
        public int $id,
        public string $nameJa,
        public string $dataType,
        public ?int $minLength,
        public ?int $maxLength,
        public ?float $minValue,
        public ?float $maxValue,
        public ?string $dateFormat,
        public ?string $unit,
        public ?array $subUnits,
        public Properties $properties
    ) {}
}
