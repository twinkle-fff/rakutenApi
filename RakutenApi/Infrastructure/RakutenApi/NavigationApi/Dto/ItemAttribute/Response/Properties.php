<?php
namespace RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute\Response;

use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;

/**
 * Class Properties
 *
 * ナビゲーションAPI（itemAttribute）レスポンス内の
 * 「属性プロパティ情報（properties）」を表す DTO。
 *
 * 主に RMS 商品属性（商品ページ属性項目）に対して、
 * - 必須項目かどうか
 * - 入力方式
 * - 複数選択の上限
 * - SKU 統一要否
 * - 楽天推奨属性かどうか
 *
 * といったメタ情報を保持する。
 *
 * ### 利用例
 * ```php
 * $props = new Properties(
 *     rmsMandatoryFlg: true,
 *     rmsMandatoryType: "ALL",
 *     rmsMultiValueLimit: 3,
 *     rmsInputMethod: "textbox",
 *     rmsSkuUnifyFlg: false,
 *     rmsRecommend: true
 * );
 * ```
 *
 * @property-read bool   $rmsMandatoryFlg     属性が RMS 上で「必須扱い」かどうか
 * @property-read string $rmsMandatoryType    必須タイプ（例: ALL / ANY / NONE）
 * @property-read int    $rmsMultiValueLimit  複数指定が可能な場合の最大数（0 なら制限なし）
 * @property-read string $rmsInputMethod      入力方式（textbox / select / checkbox など）
 * @property-read bool   $rmsSkuUnifyFlg      SKU 毎に統一が必要な項目かどうか
 * @property-read bool   $rmsRecommend        楽天が入力を推奨する項目かどうか
 */
readonly class Properties extends BaseResponseDto
{
    /**
     * @param bool   $rmsMandatoryFlg     属性が RMS 上で必須か
     * @param string $rmsMandatoryType    必須の条件タイプ（ALL/ANY/NONE）
     * @param int    $rmsMultiValueLimit  最大選択数
     * @param string $rmsInputMethod      入力方式
     * @param bool   $rmsSkuUnifyFlg      SKU間で統一が必要か
     * @param bool   $rmsRecommend        楽天が入力を推奨するか
     */
    public function __construct(
        public bool $rmsMandatoryFlg,
        public string $rmsMandatoryType,
        public int $rmsMultiValueLimit,
        public string $rmsInputMethod,
        public bool $rmsSkuUnifyFlg,
        public bool $rmsRecommend
    ) {}
}
