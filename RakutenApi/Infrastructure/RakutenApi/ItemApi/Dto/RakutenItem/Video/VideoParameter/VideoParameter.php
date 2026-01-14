<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Video\VideoParameter;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：商品動画パラメータ DTO
 *
 * 商品に紐づく動画情報のうち、単一のパラメータ値を表す DTO。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 親 DTO（Video など）からネストされた子要素として使用される
 * - 値が存在しないケースを考慮し null を許容する
 *
 * 主に動画URL、埋め込み用ID、再生パラメータ等の
 * 「キーに紐づく値部分」を保持する用途を想定する。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "value": "https://video.rakuten.co.jp/example/abcd1234"
 * }
 * ```
 */
final readonly class VideoParameter extends BaseResponseDto
{
    /**
     * @param string|null $value
     *  動画パラメータの値（URL / ID / 設定値など）
     */
    public function __construct(
        public ?string $value
    ) {}
}
