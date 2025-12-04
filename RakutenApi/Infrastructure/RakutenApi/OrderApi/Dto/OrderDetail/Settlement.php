<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天注文詳細API：決済情報 DTO
 *
 * 注文に使用された決済手段およびカード情報などを保持するモデル。
 * 楽天APIの「settlement」系のレスポンスに対応。
 *
 * 主な用途：
 * - 決済方法コードによる注文の分類
 * - 楽天ペイ（RPay）利用判定
 * - クレジットカード情報（マスク済）による処理
 *
 * 注意点：
 * - カード番号・名義などは楽天側で既にマスク済みの情報のみ返る。
 *   生カード情報は取得できない（PCI DSS 対応）
 * - BaseResponseDto を継承しており、fromResponse() による自動生成が可能。
 */
readonly class Settlement extends BaseResponseDto
{
    /**
     * @param int         $settlementMethodCode   決済方法コード（楽天仕様の数値 ID）
     * @param string      $settlementMethod       決済方法名（例：'クレジットカード', '代金引換'）
     * @param int         $rpaySettlementFlag     楽天ペイ決済フラグ（1=RPay / 0=その他）
     * @param string|null $cardName               カードブランド名（例：'VISA'）
     * @param string|null $cardNumber             マスク済みカード番号（例：'****1234'）
     * @param string|null $cardOwner              カード名義（マスクあり）
     * @param string|null $cardYm                 有効期限（YYYYMM 形式）
     * @param int|null    $cardPayType            支払種別（例：1=一括, 2=分割）
     * @param string|null $cardInstallmentDesc    分割払いなどの説明
     */
    protected function __construct(
        public int $settlementMethodCode,
        public string $settlementMethod,
        public int $rpaySettlementFlag,
        public ?string $cardName,
        public ?string $cardNumber,
        public ?string $cardOwner,
        public ?string $cardYm,
        public ?int $cardPayType,
        public ?string $cardInstallmentDesc
    ) {}
}
