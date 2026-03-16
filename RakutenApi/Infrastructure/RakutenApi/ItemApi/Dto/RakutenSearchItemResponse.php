<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto;

use RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\RakutenItem;
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


    protected const array ARRAY_CHILD_MAP = [
        "results"=>RakutenItemInventory::class
    ];

    /**
     * @param int $numFound           トータル件数
     * @param int $offset             オフセット位置
     * @param string|null $nextCursorMark カーソルマーク（ページネーション用）
     * @param RakutenItemInventory[] $results 検索結果の商品配列
     */
    public function __construct(
        public int $numFound,
        public int $offset,
        public ?string $nextCursorMark,
        public array $results
    ) {}


}
