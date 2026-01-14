<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\SubscriptionPrice;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\SubscriptionPrice\IndividualPrice\IndividualPrice;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：定期購入価格 DTO
 *
 * 商品バリエーションにおける定期購入時の価格設定を表す。
 *
 * 本 DTO は、
 * - 定期購入の基準価格
 * - 特定回（主に初回）に適用される個別価格
 * をまとめて保持する。
 *
 * 本 DTO が扱う価格情報は、
 * - 実際の請求金額計算
 * - 割引ロジック
 * には関与せず、
 * **表示・参照用途の価格情報**
 * を表すことを目的とする。
 *
 * 構成要素:
 * - basePrice        : 定期購入の基準価格
 * - individualPrices: 回別に設定された個別価格（例：初回特別価格）
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - いずれの価格も未設定の場合を考慮し null を許容する
 *
 * 親 DTO（Variant など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "basePrice": "1980",
 *   "individualPrices": {
 *     "firstPrice": "980"
 *   }
 * }
 * ```
 */
final readonly class SubscriptionPrice extends BaseResponseDto
{
    /**
     * @param string|null $basePrice
     *  定期購入における基準価格
     *  ※ API仕様上 string として返却されるため数値変換は行わない
     *
     * @param IndividualPrice|null $individualPrices
     *  回別に設定された個別価格情報
     *  （例：初回のみ特別価格が設定されている場合など）
     */
    public function __construct(
        public ?string $basePrice,
        public ?IndividualPrice $individualPrices
    ) {}
}
