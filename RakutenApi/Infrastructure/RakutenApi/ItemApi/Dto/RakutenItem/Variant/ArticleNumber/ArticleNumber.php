<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\ArticleNumber;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\ArticleExemptionReason;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：商品コード（Article Number）DTO
 *
 * 商品バリエーションに紐づく商品コード情報を表す。
 *
 * 本 DTO が扱う Article Number は、
 * - JANコード
 * - 製品コード
 * などの **商品識別コード** を指す。
 *
 * 一方で、楽天仕様上、
 * 商品コードの登録・表示が免除されるケースが存在するため、
 * 本 DTO では **免除理由（ExemptionReason）** を併せて保持する。
 *
 * 構成要素:
 * - value            : 商品コードの値
 * - exemptionReason  : 商品コードが設定されない理由
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 商品コードが存在しない場合を考慮し、各要素は null を許容する
 * - 商品コードの妥当性検証や形式チェックは行わない
 *
 * 親 DTO（Variant など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例（コードあり）:
 * ```json
 * {
 *   "value": "4901234567890",
 *   "exemptionReason": null
 * }
 * ```
 *
 * 想定レスポンス例（コード免除）:
 * ```json
 * {
 *   "value": null,
 *   "exemptionReason": "SET_PRODUCT"
 * }
 * ```
 */
final readonly class ArticleNumber extends BaseResponseDto
{
    /**
     * @param string|null $value
     *  商品コードの値（JANコード、製品コード等）
     *
     * @param ArticleExemptionReason|null $exemptionReason
     *  商品コードが設定されない理由
     *  （セット商品、サービス商品、頒布会商品など）
     */
    public function __construct(
        public ?string $value,
        public ?ArticleExemptionReason $exemptionReason,
    ) {}
}
