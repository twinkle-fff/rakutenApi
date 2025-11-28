<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Dto;

/**
 * 楽天 商品検索API の検索条件を表す ValueObject。
 *
 * 仕様書の「検索条件一覧（title ～ basePriceTo）」をそのままプロパティに持つ。
 * すべて任意項目であり、null のものはリクエストに含めない運用を想定。
 */
class ItemSearchParams
{
    /**
     * @param string|null $title                     商品名（部分一致）
     * @param string|null $tagline                   キャッチコピー（部分一致）
     * @param string|null $manageNumber              商品管理番号（部分一致）
     * @param string|null $itemNumber                商品番号（部分一致）
     * @param string|null $articleNumber             カタログID（部分一致）
     * @param string|null $variantId                 SKU管理番号（部分一致）
     * @param string|null $merchantDefinedSkuId      システム連携用SKU番号（部分一致）
     * @param string|null $genreId                   ジャンルID（完全一致）
     * @param string|null $itemType                  商品種別（NORMAL / PRE_ORDER / BUYING_CLUB）
     * @param int|null    $standardPriceFrom         販売価格下限
     * @param int|null    $standardPriceTo           販売価格上限
     * @param bool|null   $isVariantStockout         SKU在庫切れフラグ
     * @param bool|null   $isItemStockout            商品在庫切れフラグ
     * @param string|null $purchasablePeriodFrom     販売期間指定開始（YYYY-MM-DD）
     * @param string|null $purchasablePeriodTo       販売期間指定終了（YYYY-MM-DD）
     * @param bool|null   $isHiddenItem              商品倉庫指定フラグ
     * @param bool|null   $isHiddenVariant           SKU倉庫指定フラグ
     * @param bool|null   $isSearchable              サーチ表示フラグ
     * @param bool|null   $isYamiichi                闇市フラグ
     * @param string|null $pointApplicablePeriodFrom ポイント変倍適用期間開始日（YYYY-MM-DD）
     * @param string|null $pointApplicablePeriodTo   ポイント変倍適用期間終了日（YYYY-MM-DD）
     * @param bool|null   $isOptimizedPoint          ポイント変倍種別（true:運用型 / false:通常）
     * @param int|null    $pointRate                 ポイント変倍率（1～20）
     * @param int|null    $maxPointRate              ポイント上限倍率（2～20）
     * @param string|null $categoryId                カテゴリID
     * @param bool|null   $isBackOrder               在庫切れ時の注文受付
     * @param bool|null   $isPostageIncluded         送料無料フラグ
     * @param string|null $createdFrom               検索開始日（登録日, YYYY-MM-DD）
     * @param string|null $createdTo                 検索終了日（登録日, YYYY-MM-DD）
     * @param string|null $updatedFrom               検索開始日（更新日, YYYY-MM-DD）
     * @param string|null $updatedTo                 検索終了日（更新日, YYYY-MM-DD）
     * @param string|null $sortKey                   ソートキー
     * @param string|null $sortOrder                 ソート順 desc/asc
     * @param int|null    $offset                    検索結果取得開始位置（0～10000）
     * @param int|null    $hits                      検索結果取得上限数（1～100, デフォルト10）
     * @param string|null $cursorMark                カーソルマーク
     * @param bool|null   $isCategoryIncluded        店舗内カテゴリ情報返却フラグ
     * @param bool|null   $isReviewIncluded          レビュー情報返却フラグ
     * @param bool|null   $isInventoryIncluded       在庫情報返却フラグ
     * @param bool|null   $isSubscription            定期購入設定フラグ
     * @param int|null    $basePriceFrom             定期/頒布会 価格下限
     * @param int|null    $basePriceTo               定期/頒布会 価格上限
     */
    public function __construct(
        public ?string $title = null,
        public ?string $tagline = null,
        public ?string $manageNumber = null,
        public ?string $itemNumber = null,
        public ?string $articleNumber = null,
        public ?string $variantId = null,
        public ?string $merchantDefinedSkuId = null,
        public ?string $genreId = null,
        public ?string $itemType = null,
        public ?int $standardPriceFrom = null,
        public ?int $standardPriceTo = null,
        public ?bool $isVariantStockout = null,
        public ?bool $isItemStockout = null,
        public ?string $purchasablePeriodFrom = null,
        public ?string $purchasablePeriodTo = null,
        public ?bool $isHiddenItem = null,
        public ?bool $isHiddenVariant = null,
        public ?bool $isSearchable = null,
        public ?bool $isYamiichi = null,
        public ?string $pointApplicablePeriodFrom = null,
        public ?string $pointApplicablePeriodTo = null,
        public ?bool $isOptimizedPoint = null,
        public ?int $pointRate = null,
        public ?int $maxPointRate = null,
        public ?string $categoryId = null,
        public ?bool $isBackOrder = null,
        public ?bool $isPostageIncluded = null,
        public ?string $createdFrom = null,
        public ?string $createdTo = null,
        public ?string $updatedFrom = null,
        public ?string $updatedTo = null,
        public ?string $sortKey = null,
        public ?string $sortOrder = null,
        public ?int $offset = null,
        public ?int $hits = 100,
        public ?string $cursorMark = null,
        public ?bool $isCategoryIncluded = null,
        public ?bool $isReviewIncluded = null,
        public ?bool $isInventoryIncluded = null,
        public ?bool $isSubscription = null,
        public ?int $basePriceFrom = null,
        public ?int $basePriceTo = null,
    ) {}

    /**
     * 全項目 null の空インスタンスを生成する。
     *
     * @return self
     */
    public static function empty(): self
    {
        return new self();
    }

    /**
     * 連想配列からインスタンスを生成する。
     *
     * 配列キーはプロパティ名と同一（title, tagline, manageNumber, ...）。
     * 指定されていないキーは null になる。
     *
     * @param array<string,mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'] ?? null,
            $data['tagline'] ?? null,
            $data['manageNumber'] ?? null,
            $data['itemNumber'] ?? null,
            $data['articleNumber'] ?? null,
            $data['variantId'] ?? null,
            $data['merchantDefinedSkuId'] ?? null,
            $data['genreId'] ?? null,
            $data['itemType'] ?? null,
            $data['standardPriceFrom'] ?? null,
            $data['standardPriceTo'] ?? null,
            $data['isVariantStockout'] ?? null,
            $data['isItemStockout'] ?? null,
            $data['purchasablePeriodFrom'] ?? null,
            $data['purchasablePeriodTo'] ?? null,
            $data['isHiddenItem'] ?? null,
            $data['isHiddenVariant'] ?? null,
            $data['isSearchable'] ?? null,
            $data['isYamiichi'] ?? null,
            $data['pointApplicablePeriodFrom'] ?? null,
            $data['pointApplicablePeriodTo'] ?? null,
            $data['isOptimizedPoint'] ?? null,
            $data['pointRate'] ?? null,
            $data['maxPointRate'] ?? null,
            $data['categoryId'] ?? null,
            $data['isBackOrder'] ?? null,
            $data['isPostageIncluded'] ?? null,
            $data['createdFrom'] ?? null,
            $data['createdTo'] ?? null,
            $data['updatedFrom'] ?? null,
            $data['updatedTo'] ?? null,
            $data['sortKey'] ?? null,
            $data['sortOrder'] ?? null,
            $data['offset'] ?? 0,
            $data['hits'] ?? 100,
            $data['cursorMark'] ?? null,
            $data['isCategoryIncluded'] ?? null,
            $data['isReviewIncluded'] ?? null,
            $data['isInventoryIncluded'] ?? null,
            $data['isSubscription'] ?? null,
            $data['basePriceFrom'] ?? null,
            $data['basePriceTo'] ?? null,
        );
    }

    /**
     * 動的 setter: キー名を指定して値を設定する。
     *
     * 例）$params->set('title', 'コーヒー');
     *
     * @param string $key   プロパティ名
     * @param mixed  $value 設定する値
     * @return self
     *
     * @throws \InvalidArgumentException 未定義プロパティを指定した場合
     */
    public function set(string $key, mixed $value): self
    {
        if (!property_exists($this, $key)) {
            throw new \InvalidArgumentException("Unknown property: $key");
        }
        $this->$key = $value;
        return $this;
    }

    /**
     * setterチェーン (setTitle(), setItemType() など) を動的に解決する。
     *
     * 例）$params->setTitle('コーヒー')->setStandardPriceFrom(1000);
     *
     * @param string $name      メソッド名
     * @param array<int,mixed> $arguments 引数（先頭要素のみ使用）
     * @return self
     *
     * @throws \BadMethodCallException 未定義メソッドが呼ばれた場合
     */
    public function __call($name, $arguments)
    {
        if (str_starts_with($name, 'set')) {
            $prop = lcfirst(substr($name, 3));
            if (property_exists($this, $prop)) {
                $this->$prop = $arguments[0] ?? null;
                return $this;
            }
        }
        throw new \BadMethodCallException("Undefined method: $name");
    }

    /**
     * 現在の状態を連想配列として返す。
     *
     * API クライアント層で「null を除外してリクエスト配列に変換する」などの用途を想定。
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return array_map(fn($n)=>($n===true?"true":$n),get_object_vars($this));
    }
}
