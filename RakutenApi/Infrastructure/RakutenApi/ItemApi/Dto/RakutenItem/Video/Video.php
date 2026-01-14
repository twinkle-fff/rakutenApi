<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Video;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Video\VideoParameter\VideoParameter;
use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\VideoType;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：商品動画 DTO
 *
 * 商品に紐づく動画情報を表す。
 *
 * - 動画の種別（例：商品紹介動画、使い方動画など）を {@see VideoType} で表現する
 * - 動画に付随するパラメータ（URL / ID / 再生設定など）を {@see VideoParameter} として保持する
 * - いずれの要素も存在しないケースを考慮し null を許容する
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "type": "PRODUCT",
 *   "parameters": {
 *     "value": "https://video.rakuten.co.jp/example/abcd1234"
 *   }
 * }
 * ```
 */
final readonly class Video extends BaseResponseDto
{
    /**
     * @param VideoType|null $type
     *  動画の種別
     *
     * @param VideoParameter|null $parameters
     *  動画に紐づくパラメータ情報
     */
    public function __construct(
        public ?VideoType $type,
        public ?VideoParameter $parameters
    ) {}
}
