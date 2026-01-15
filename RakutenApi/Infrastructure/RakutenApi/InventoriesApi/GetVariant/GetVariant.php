<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesApi\GetVariant;

use Exception;
use HttpClient\Infrastructure\Enum\RequestType;
use InvalidArgumentException;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\GetVariant\Dto\Response\GetVariantResponse;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;
use Throwable;

/**
 * 楽天RMS Inventories API
 * バリエーション（SKU）在庫情報取得クライアント
 *
 * 指定された商品管理番号（manageNumber）および
 * バリエーションID（SKU）に紐づく在庫・配送関連情報を取得する。
 *
 * 本クラスは Infrastructure 層に属し、
 * - HTTP通信
 * - エンドポイントURL構築
 * - レスポンスDTO変換
 * を責務とする。
 *
 * 楽天RMS API 固有のレスポンス構造は
 * GetVariantResponse DTO に委譲し、
 * Application / Domain 層へは DTO のみを返却する。
 */
class GetVariant
{
    /** @var RakutenApiClient 楽天RMS API クライアント */
    private RakutenApiClient $client;

    /**
     * バリエーション在庫取得エンドポイント
     *
     * {manageNumber} : 商品管理番号
     * {variantId}    : バリエーション（SKU）ID
     */
    private const ENDPOINT_PREFIX =
        "https://api.rms.rakuten.co.jp/es/2.1/inventories/manage-numbers/{manageNumber}/variants/{variantId}";

    /**
     * @param RakutenApiClient|null $client
     *        楽天APIクライアント（未指定時はデフォルト生成）
     */
    public function __construct(?RakutenApiClient $client = null)
    {
        $this->client = $client ?? new RakutenApiClient();
    }

    /**
     * バリエーション（SKU）の在庫情報を取得する
     *
     * @param string $manageNumber
     *        RMS上の商品管理番号
     *
     * @param string $sku
     *        バリエーション（SKU）ID
     *
     * @return GetVariantResponse
     *         SKU単位の在庫・配送・管理情報レスポンスDTO
     *
     * @throws InvalidArgumentException
     *         レスポンスの解析に失敗した場合
     */
    public function execute(string $manageNumber, string $sku): GetVariantResponse
    {
        $url = $this->buildUrl($manageNumber, $sku);

        $res = $this->client->request(
            RequestType::GET,
            $url,
            []
        );

        return $this->handleResponse($res);
    }

    /**
     * APIエンドポイントURLを構築する
     *
     * @param string $manageNumber
     *        商品管理番号
     *
     * @param string $sku
     *        バリエーション（SKU）ID
     *
     * @return string
     *         実リクエスト用URL
     */
    private function buildUrl(string $manageNumber, string $sku): string
    {
        return str_replace(
            ["{manageNumber}", "{variantId}"],
            [$manageNumber, $sku],
            self::ENDPOINT_PREFIX
        );
    }

    /**
     * APIレスポンスを DTO に変換する
     *
     * DTO変換時に例外が発生した場合は、
     * 生レスポンスを含めた InvalidArgumentException として再送出する。
     *
     * @param array $response
     *        楽天RMS API 生レスポンス
     *
     * @return GetVariantResponse
     *
     * @throws InvalidArgumentException
     *         DTO変換に失敗した場合
     */
    private function handleResponse(array $response): GetVariantResponse
    {
        try {
            return GetVariantResponse::fromResponse($response);
        } catch (Throwable $e) {
            $res = json_encode($response, JSON_UNESCAPED_UNICODE);
            throw new InvalidArgumentException(
                "バリエーション在庫情報の取得に失敗しました。response:{$res}",
                previous: $e
            );
        }
    }
}
