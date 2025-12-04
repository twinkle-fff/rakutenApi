<?php

namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * 楽天注文詳細API：ポイント利用情報 DTO
 *
 * 注文で利用されたポイント数を表すシンプルなデータモデル。
 * BaseResponseDto により、API レスポンスから自動的にマッピングされる。
 *
 * 主に以下の用途で使用：
 * - 注文金額からポイント差し引き計算
 * - 注文履歴のポイント利用内訳表示
 * - 外部処理（会計・分析）への受け渡し
 */
readonly class Point extends BaseResponseDto
{
    /**
     * @param int $usedPoint 注文で消費された楽天ポイント数
     */
    protected function __construct(
        public int $usedPoint
    ) {}
}
