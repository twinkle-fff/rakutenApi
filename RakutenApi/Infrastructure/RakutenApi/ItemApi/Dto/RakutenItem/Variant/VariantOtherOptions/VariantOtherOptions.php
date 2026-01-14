<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Variant\VariantOtherOptions;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：バリエーションその他オプション DTO
 *
 * 商品バリエーションに付随する、
 * 主要な価格・在庫・表示設定以外の補助的なオプション設定を表す。
 *
 * 本 DTO は、
 * - 再入荷通知の可否
 * - のし対応可否
 * といった、購入体験に影響する付加設定を保持する。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 各オプションは設定されていないケースを考慮し null を許容する
 *
 * 親 DTO（Variant など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "restockNotification": true,
 *   "noshi": false
 * }
 * ```
 */
final readonly class VariantOtherOptions extends BaseResponseDto
{
    /**
     * @param bool|null $restockNotification
     *  在庫切れ時に再入荷通知を受け取れるかどうか
     *
     * @param bool|null $noshi
     *  のし対応が可能かどうか
     */
    public function __construct(
        public ?bool $restockNotification,
        public ?bool $noshi
    ) {}
}
