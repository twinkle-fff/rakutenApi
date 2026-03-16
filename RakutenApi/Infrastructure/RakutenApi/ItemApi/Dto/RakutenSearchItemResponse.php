<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天「searchItems」API の正常系レスポンスDTO
 *
 * - HTTP通信およびエラー処理は担当しない
 * - APIのレスポンス(JSON配列)を型安全に扱うためのクラス
 * - read-only かつ private constructor で不変オブジェクトとして扱う
 */
readonly class RakutenSearchItemResponse extends BaseResponseDto
{
    /**
     * @param int $numFound           トータル件数
     * @param int $offset             オフセット位置
     * @param string|null $nextCursorMark カーソルマーク（ページネーション用）
     * @param RakutenItem[] $results 検索結果の商品配列
     */
    public function __construct(
        public int $numFound,
        public int $offset,
        public ?string $nextCursorMark,
        public array $results
    ) {}

    protected const array ARRAY_CHILD_MAP = [
        "results"=>RakutenItem::class
    ];

    // /**
    //  * レスポンス配列からDTOを生成するファクトリメソッド
    //  *
    //  * @param array<string,mixed> $response APIの生のレスポンス配列
    //  * @return self
    //  *
    //  * @throws \InvalidArgumentException 必須キーが存在しない場合
    //  */
    // public static function fromResponse(array $response): self
    // {
    //     if (!isset($response["numFound"], $response["offset"], $response["results"])) {
    //         throw new \InvalidArgumentException(
    //             "Invalid response: 'numFound', 'offset', and 'results' are required."
    //         );
    //     }

    //     return new self(
    //         numFound: (int)$response["numFound"],
    //         offset: (int)$response["offset"],
    //         nextCursorMark: $response["nextCursorMark"] ?? null,
    //         results: $response["results"],
    //     );
    // }
}
