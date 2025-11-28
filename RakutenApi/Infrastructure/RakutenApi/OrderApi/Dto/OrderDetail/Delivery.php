<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天注文詳細API：配送方法情報 DTO
 *
 * 注文に対して選択された配送方法の名称と区分コードを保持するモデル。
 *
 * 主に以下の用途で使用：
 * - 注文の配送手段の特定（宅配便 / メール便 / 店舗受取 など）
 * - 配送会社コードではなく「配送方法の種別」を扱う際に利用
 * - 料金計算や配送分類ロジックの補助
 *
 * ※ BaseResponseDto を継承していないため、
 *    必要であれば今後 fromResponse() 対応する余地あり。
 */
readonly class Delivery extends BaseResponseDto
{
    /**
     * @param string $deliveryName  UI上に表示される配送方法名
     * @param int    $deliveryClass 配送方法区分（楽天API仕様に準拠）
     */
    protected function __construct(
        public string $deliveryName,
        public int $deliveryClass
    ) {}
}
