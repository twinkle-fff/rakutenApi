<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\WhiteBgImage;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\ImageType;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：白背景画像 DTO
 *
 * 楽天が定義する「白背景画像（ホワイトバック画像）」を表す DTO。
 * 主に検索結果表示・広告・ガイドライン準拠用途の画像として利用される。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 画像の種別は {@see ImageType} で表現される
 * - 画像URLのみを保持し、alt テキスト等は含まない仕様
 *
 * 親 DTO（RakutenItem など）から単体、または配列要素として参照される想定。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "type": "WHITE_BG",
 *   "location": "https://image.rakuten.co.jp/example/item/white_bg.jpg"
 * }
 * ```
 */
final readonly class WhiteBgImage extends BaseResponseDto
{
    /**
     * @param ImageType|null $type
     *  白背景画像の種別
     *
     * @param string|null $location
     *  白背景画像のURL
     */
    public function __construct(
        public ?ImageType $type,
        public ?string $location
    ) {}
}
