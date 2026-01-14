<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\Shipping;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\Shipping\PostageSegment\PostageSegment;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\SingleItemShipping;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：配送・送料設定 DTO
 *
 * 商品バリエーションにおける配送条件および送料関連の設定を表す。
 *
 * 本 DTO は、
 * - 送料の有無・表示
 * - 国内／海外配送区分
 * - 同梱可否に影響する配送制約
 * といった **配送に関する設定情報** を集約する。
 *
 * 本 DTO が保持する情報は、
 * - 実際の送料計算
 * - 配送可否判定ロジック
 * を行うものではなく、
 * **楽天APIが返却する配送設定情報をそのまま保持する**
 * ことを目的とする。
 *
 * 構成要素:
 * - fee                    : 表示用送料値
 * - postageIncluded        : 送料込み表示フラグ
 * - shopAreaSoryoPatternId : 店舗別・地域別送料パターンID
 * - shippingMethodGroup    : 配送方法グループ
 * - postageSegment         : 国内／海外ごとの送料区分
 * - overseasDeliveryId     : 海外配送設定ID
 * - singleItemShipping     : 単品配送制約区分
 * - okihaiSetting          : 置き配可否設定
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 各設定は存在しないケースを考慮し null を許容する
 *
 * 親 DTO（Variant など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "fee": "500",
 *   "postageIncluded": false,
 *   "shopAreaSoryoPatternId": 12,
 *   "shippingMethodGroup": "NORMAL",
 *   "postageSegment": {
 *     "local": 1,
 *     "overseas": 3
 *   },
 *   "overseasDeliveryId": 2,
 *   "singleItemShipping": "DIRECT_FROM_MANUFACTURER",
 *   "okihaiSetting": true
 * }
 * ```
 */
final readonly class Shipping extends BaseResponseDto
{
    /**
     * @param string|null $fee
     *  表示用の送料値
     *  ※ 実際の送料計算には用いない
     *
     * @param bool|null $postageIncluded
     *  送料込み表示かどうか
     *
     * @param int|null $shopAreaSoryoPatternId
     *  店舗・地域別送料パターンの識別ID
     *
     * @param string|null $shippingMethodGroup
     *  配送方法のグループ識別子
     *
     * @param PostageSegment|null $postageSegment
     *  国内／海外配送ごとの送料区分
     *
     * @param int|null $overseasDeliveryId
     *  海外配送設定の識別ID
     *
     * @param SingleItemShipping|null $singleItemShipping
     *  同梱不可などの単品配送制約区分
     *
     * @param bool|null $okihaiSetting
     *  置き配対応可否
     */
    public function __construct(
        public ?string $fee,
        public ?bool $postageIncluded,
        public ?int $shopAreaSoryoPatternId,
        public ?string $shippingMethodGroup,
        public ?PostageSegment $postageSegment,
        public ?int $overseasDeliveryId,
        public ?SingleItemShipping $singleItemShipping,
        public ?bool $okihaiSetting
    ) {}
}
