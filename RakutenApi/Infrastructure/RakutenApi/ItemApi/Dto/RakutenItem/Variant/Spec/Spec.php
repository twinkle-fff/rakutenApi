<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\Spec;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：商品仕様（スペック）DTO
 *
 * 商品バリエーションに紐づく個別仕様情報を表す。
 *
 * 本 DTO は、
 * - 仕様項目名（ラベル）
 * - 仕様内容（値）
 * を 1 組として保持し、
 * 商品ページ上で表示されるスペック情報を表現する。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 仕様が設定されていないケースを考慮し null を許容する
 * - 表示・参照用途に特化し、数値変換や単位解釈は行わない
 *
 * 親 DTO（Variant など）から配列要素として参照される想定。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "label": "容量",
 *   "value": "500ml"
 * }
 * ```
 */
final readonly class Spec extends BaseResponseDto
{
    /**
     * @param string|null $label
     *  仕様項目の名称
     *  （例：「容量」「サイズ」「素材」など）
     *
     * @param string|null $value
     *  仕様項目の内容
     *  （例：「500ml」「M」「綿100%」など）
     */
    public function __construct(
        public ?string $label,
        public ?string $value
    ) {}
}
