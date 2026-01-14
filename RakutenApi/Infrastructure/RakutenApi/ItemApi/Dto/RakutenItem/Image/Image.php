<?php

namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Image;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum\ImageType;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：商品画像 DTO
 *
 * 商品に紐づく画像情報を表す。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 画像種別（メイン画像 / サブ画像 等）は {@see ImageType} で表現される
 * - 表示用代替テキスト（alt）を含む
 *
 * 親 DTO（RakutenItem など）の images 配列要素として利用される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "type": "MAIN",
 *   "location": "https://image.rakuten.co.jp/example/item/12345.jpg",
 *   "alt": "商品の正面画像"
 * }
 * ```
 */
final readonly class Image extends BaseResponseDto
{
    /**
     * @param ImageType|null $type
     *  画像の種別（例：MAIN / SUB / THUMBNAIL など）
     *
     * @param string|null $location
     *  画像URL
     *
     * @param string|null $alt
     *  画像の代替テキスト（アクセシビリティ・SEO向け）
     */
    public function __construct(
        public ?ImageType $type,
        public ?string $location,
        public ?string $alt
    ) {}
}
