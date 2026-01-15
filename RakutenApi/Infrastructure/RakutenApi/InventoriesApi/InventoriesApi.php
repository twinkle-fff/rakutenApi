<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesApi;

use RakutenApi\Application\Port\RakutenApi\InventoriesApiPort;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\GetVariant\Dto\Response\GetVariantResponse;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\GetVariant\GetVariant;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\UpsertVariants\Dto\Request\UpsertVariantRequest;
use RakutenApi\Infrastructure\RakutenApi\InventoriesApi\UpsertVariants\UpsertVariants;
use RakutenApi\Infrastructure\RakutenApi\Shared\RakutenApiClient;

/**
 * 楽天RMS Inventories API 実装（Infrastructure）
 *
 * Application層が参照する InventoriesApiPort の具体実装。
 * - SKU（バリエーション）在庫の取得（GetVariant）
 * - SKU在庫の登録・更新（UpsertVariants）
 *
 * 低レイヤのHTTP通信は RakutenApiClient に委譲し、
 * 本クラスは「ユースケースから使いやすい形で Inventories API を束ねる」ことを責務とする。
 */
final class InventoriesApi implements InventoriesApiPort
{
    /** @var UpsertVariants SKU在庫の登録・更新クライアント */
    public UpsertVariants $upsertVariants;

    /** @var GetVariant SKU在庫情報取得クライアント */
    public GetVariant $getVariant;

    /**
     * Inventories API（variant）系エンドポイント（参考用）
     * ※個別クライアントで実際のURL生成を行う想定
     */
    public const string ENDPOINT_PREFIX =
        "https://api.rms.rakuten.co.jp/es/2.1/inventories/manage-numbers/{manageNumber}/variants/{variantId}";

    /**
     * @param RakutenApiClient|null $client
     *        楽天RMS APIクライアント（未指定時はデフォルト生成）
     */
    public function __construct(?RakutenApiClient $client = null)
    {
        $client ??= new RakutenApiClient();
        $this->upsertVariants = new UpsertVariants($client);
        $this->getVariant     = new GetVariant($client);
    }

    /**
     * {@inheritDoc}
     *
     * @param UpsertVariantRequest|array $upsertVariantRequest
     *        在庫・配送・出荷元などの更新内容
     */
    public function upsertVariants(
        string $manageNumber,
        string $sku,
        array|UpsertVariantRequest $upsertVariantRequest
    ): bool {
        return $this->upsertVariants->execute($manageNumber, $sku, $upsertVariantRequest);
    }

    /**
     * {@inheritDoc}
     */
    public function getVariant(string $manageNumber, string $sku): GetVariantResponse
    {
        return $this->getVariant->execute($manageNumber, $sku);
    }
}

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    require_once __DIR__."/../../../../vendor/autoload.php";

    $ia = new InventoriesApi();
    $upsertVariantRequest = UpsertVariantRequest::empty()
        ->set("mode", \RakutenApi\Infrastructure\RakutenApi\InventoriesApi\Enum\Mode::ABSOLUTE)
        ->set("quantity", 500);

    $ia->upsertVariants("22m0e3iuhb7rcorc", "ippon", $upsertVariantRequest);
}
