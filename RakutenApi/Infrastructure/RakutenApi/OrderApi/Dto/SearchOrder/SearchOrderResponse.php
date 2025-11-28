<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\SearchOrder;

use InvalidArgumentException;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;

/**
 * 楽天API「注文番号検索」のレスポンスDTO。
 *
 * APIから返却される MessageModelList・orderNumberList・ページネーション情報を
 * ドメインオブジェクトとしてまとめるためのクラス。
 *
 * @package RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\SearchOrder
 */
readonly class SearchOrderResponse
{
    /**
     * @param array $messageModel
     *   APIから返却されるエラーメッセージ／情報メッセージの配列
     *   （MessageModelList 相当）
     *
     * @param RakutenOrderNumber[] $orderNumberList
     *   正常に取得された注文番号のリスト
     *
     * @param int|null $recordAmount
     *   総件数（totalRecordsAmount）
     *
     * @param int|null $totalPages
     *   総ページ数（totalPages）
     *
     * @param int|null $requestPage
     *   今回リクエストしたページ番号（requestPage）
     */
    private function __construct(
        public array  $messageModel,
        public array  $orderNumberList,
        public ?int   $recordAmount,
        public ?int   $totalPages,
        public ?int   $requestPage
    ) {}

    /**
     * APIレスポンス配列から SearchOrderResponse を生成する。
     *
     * @param array $response
     *   楽天APIの「注文番号検索」レスポンス配列
     * @return SearchOrderResponse
     * @throws InvalidArgumentException
     *   MessageModelList が存在しない場合
     */
    public static function fromResponse(array $response): SearchOrderResponse
    {
        // ⬇ 本文のバグを修正：$data は存在しない → $response を参照すべき
        if (empty($response["MessageModelList"] ?? [])) {
            throw new InvalidArgumentException(
                "注文番号検索に失敗しました。メッセージモデルリストが存在しませんでした。"
            );
        }

        return new SearchOrderResponse(
            $response["MessageModelList"],
            array_map(
                fn($n) => new RakutenOrderNumber($n),
                $response["orderNumberList"] ?? []
            ),
            $response["PaginationResponseModel"]["totalRecordsAmount"] ?? null,
            $response["PaginationResponseModel"]["totalPages"] ?? null,
            $response["PaginationResponseModel"]["requestPage"] ?? null,
        );
    }
}
