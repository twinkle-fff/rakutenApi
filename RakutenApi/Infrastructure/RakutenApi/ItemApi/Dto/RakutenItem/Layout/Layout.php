<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\Layout;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：商品ページレイアウト設定 DTO
 *
 * 商品ページの表示構成に関するレイアウト設定を表す。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 商品ページの各構成要素（レイアウト、ナビゲーション、説明文表示枠など）の
 *   設定IDを保持する
 * - 各 ID は楽天側で管理される識別子であり、数値として扱う
 *
 * 親 DTO（RakutenItem など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "itemLayoutId": 123,
 *   "navigationId": 45,
 *   "layoutSequenceId": 7,
 *   "smallDescriptionId": 10,
 *   "largeDescriptionId": 20,
 *   "showcaseId": 3
 * }
 * ```
 */
final readonly class Layout extends BaseResponseDto
{
    /**
     * @param int $itemLayoutId
     *  商品ページ全体のレイアウトID
     *
     * @param int $navigationId
     *  ナビゲーション表示設定ID
     *
     * @param int $layoutSequenceId
     *  レイアウト表示順序の設定ID
     *
     * @param int $smallDescriptionId
     *  簡易説明文表示枠の設定ID
     *
     * @param int $largeDescriptionId
     *  詳細説明文表示枠の設定ID
     *
     * @param int $showcaseId
     *  商品ショーケース表示設定ID
     */
    public function __construct(
        public int $itemLayoutId,
        public int $navigationId,
        public int $layoutSequenceId,
        public int $smallDescriptionId,
        public int $largeDescriptionId,
        public int $showcaseId,
    ) {}
}
