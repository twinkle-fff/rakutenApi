<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天注文詳細API：ラッピング情報 DTO
 *
 * ラッピング（ギフト包装）に関する設定を保持するクラス。
 * タイトル（ラッピング種別）、名称、価格、税率、税込計算関連の値などを含む。
 *
 * ※ BaseResponseDto を継承していない点に注意。
 *    必要なら後で継承構造に合わせて変更可能。
 */
readonly class Wrapping extends BaseResponseDto
{
    /**
     * @param int         $title               ラッピング種類コード（例：1=リボン包装 等）
     * @param string      $name                ラッピング名称（例：「ギフト用リボン」）
     * @param int|null    $price               ラッピング料金（税抜）。未設定の場合 null
     * @param int         $includeTaxFlag      ラッピング料金の税込フラグ（0/1）
     * @param int         $deleteWrappingFlag  削除済みラッピングフラグ（0:通常 / 1:削除）
     * @param float       $taxRate             税率（例：10.0）
     * @param int         $taxPrice            税額（price × 税率 の計算結果）
     */
    protected function __construct(
        public int $title,
        public string $name,
        public ?int $price,
        public int $includeTaxFlag,
        public int $deleteWrappingFlag,
        public float $taxRate,
        public int $taxPrice,
    ) {}
}
