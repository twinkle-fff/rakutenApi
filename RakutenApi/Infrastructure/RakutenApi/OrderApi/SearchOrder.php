<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi;

use Exception;
use HttpClient\Infrastructure\Enum\RequestType;
use HttpClient\Infrastructure\ValueObject\HttpParams;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\SearchOrder\SearchOrderParams;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\SearchOrder\SearchOrderResponse;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

/**
 * 楽天API「注文番号検索 (order/searchOrder)」を呼び出すユースケースクラス。
 *
 * SearchOrderParams で構築した検索条件を楽天APIの形式へ正規化し、
 * RakutenApiClient を通じて API リクエストを実行。
 *
 * APIレスポンスは SearchOrderResponse DTO として返却される。
 *
 * @package RakutenApi\Infrastructure\RakutenApi\OrderApi
 */
class SearchOrder
{
    /**
     * 楽天APIクライアント
     *
     * @var RakutenApiClient
     */
    private RakutenApiClient $client;

    /**
     * 注文検索APIのエンドポイントURL。
     * (楽天 API ドキュメント：es/2.0/order/searchOrder/)
     */
    private const SEARCH_ORDER_ENDPOINT = "https://api.rms.rakuten.co.jp/es/2.0/order/searchOrder/";

    /**
     * @param RakutenApiClient|null $client
     *   DI される場合は外部からクライアントを注入。
     *   null の場合は内部で新しい RakutenApiClient を生成。
     */
    public function __construct(
        ?RakutenApiClient $client = null,
    ) {
        $this->client = $client ?? new RakutenApiClient();
    }

    /**
     * 注文番号検索 API を実行する。
     *
     * @param array|SearchOrderParams $params
     *   - 検索条件配列
     *   - または SearchOrderParams DTO
     *
     * @return SearchOrderResponse
     *   API の返却内容を SearchOrderResponse DTO として返す
     *
     * @throws Exception
     *   - 楽天API通信失敗時
     *   - SearchOrderResponse::fromResponse が例外を投げた場合
     */
    public function execute(array|SearchOrderParams $params): SearchOrderResponse
    {
        $httpParams = $this->normalizeParam($params);

        $response = $this->client->request(
            RequestType::POST,
            self::SEARCH_ORDER_ENDPOINT,
            $httpParams,
        );

        return SearchOrderResponse::fromResponse($response);
    }

    /**
     * 渡された検索条件を SearchOrderParams DTO → HttpParams に変換する。
     *
     * APIクライアントが受け取る形式（HttpParams）に正規化する責務を持つ。
     *
     * @param array|SearchOrderParams $params
     *   - 配列で渡された場合は SearchOrderParams::fromArray() で組み立てる
     *   - DTO の場合はそのまま使用
     *
     * @return HttpParams
     *   APIクライアントに渡すための HTTP パラメータオブジェクト
     */
    private function normalizeParam(array|SearchOrderParams $params): HttpParams
    {
        $normalizedParams = ($params instanceof SearchOrderParams)
            ? $params
            : SearchOrderParams::fromArray($params);

        return HttpParams::fromArray($normalizedParams->toArray());
    }
}
