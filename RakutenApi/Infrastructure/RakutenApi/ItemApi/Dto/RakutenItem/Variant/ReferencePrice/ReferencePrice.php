<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\ReferencePrice;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\PriceDisplayMessageType;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\PriceDisplayType;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：参照価格（表示用価格情報）DTO
 *
 * 商品バリエーションにおいて、
 * 「販売価格そのもの」ではなく、
 * **価格表示の比較・注記用途で参照される価格情報**
 * を表す。
 *
 * 本 DTO が表す ReferencePrice は、
 * - 実際の販売価格
 * - 請求・決済に用いられる価格
 * ではなく、
 * **表示・説明・比較のための価格**
 * である。
 *
 * 構成要素:
 * - {@see PriceDisplayType}        : 価格表示方法（例：税込 / 税抜 等）
 * - {@see PriceDisplayMessageType} : 価格の参照元・表示種別
 * - value                          : 表示対象となる価格値
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 金額計算・税計算は行わず、表示情報の保持に専念する
 *
 * 親 DTO（Variant など）から単体、または配列要素として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "displayType": "TAX_INCLUDED",
 *   "type": "MANUFACTURER_SUGGESTED_RETAIL_PRICE",
 *   "value": "10000"
 * }
 * ```
 */
final readonly class ReferencePrice extends BaseResponseDto
{
    /**
     * @param PriceDisplayType $displayType
     *  価格の表示方法（例：税込 / 税抜）
     *
     * @param PriceDisplayMessageType $type
     *  価格表示メッセージの種別
     *  （当店通常価格 / メーカー希望小売価格 / 価格ナビ参照 等）
     *
     * @param string $value
     *  表示対象となる価格値
     *  ※ API仕様上 string として返却されるため数値変換は行わない
     */
    public function __construct(
        public PriceDisplayType $displayType,
        public PriceDisplayMessageType $type,
        public string $value
    ) {}
}
