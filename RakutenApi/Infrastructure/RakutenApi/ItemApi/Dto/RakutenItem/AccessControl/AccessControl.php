<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto\RakutenItem\AccessControl;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天商品API：アクセス制御設定 DTO
 *
 * 商品ページへのアクセス制限に関する設定を表す。
 *
 * - APIレスポンス配列から {@see BaseResponseDto::fromResponse()} により生成される
 * - 特定の購入者・閲覧者のみがアクセス可能な商品を実現するための情報を保持する
 * - アクセス制御が設定されていない場合を考慮し null を許容する
 *
 * 親 DTO（RakutenItem など）から単体の子 DTO として参照される。
 *
 * 想定レスポンス例:
 * ```json
 * {
 *   "accessPassword": "secret123"
 * }
 * ```
 */
final readonly class AccessControl extends BaseResponseDto
{
    /**
     * @param string|null $accessPassword
     *  商品ページへのアクセスに必要なパスワード
     */
    public function __construct(
        public ?string $accessPassword
    ) {}
}
