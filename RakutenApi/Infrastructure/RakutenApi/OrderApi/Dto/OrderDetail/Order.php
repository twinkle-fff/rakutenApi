<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\OrderDetail;

use DateTime;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared\BaseResponseDto;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Enum\OrderProgress;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;

/**
 * 楽天注文詳細API：注文情報ルート DTO
 *
 * 1件の注文に紐づくステータス・金額・配送・決済・ポイント・
 * パッケージ・クーポン・期限情報などをまとめて保持するモデル。
 *
 * BaseResponseDto を継承しており、fromResponse() により
 * 楽天APIレスポンスの連想配列から自動でマッピング・型変換される。
 *
 * ARRAY_CHILD_MAP によって以下の配列プロパティが要素ごとに変換される：
 * - receiptIssueHistoryList : DateTime[]
 * - PackageModelList        : Package[]
 * - CouponModelList         : Coupen[]
 * - ChangeReasonModelList   : ChangeReason[]
 * - TaxSummaryModelList     : TaxSummary[]
 * - DueDateModelList        : DueDate[]
 */
readonly class Order extends BaseResponseDto
{
    /**
     * 配列プロパティの要素クラスを指定するマッピング。
     */
    protected const array ARRAY_CHILD_MAP = [
        'receiptIssueHistoryList' => DateTime::class,
        'PackageModelList'        => Package::class,
        'CouponModelList'         => Coupen::class,
        'ChangeReasonModelList'   => ChangeReason::class,
        'TaxSummaryModelList'     => TaxSummary::class,
        'DueDateModelList'        => DueDate::class,
    ];

    /**
     * @param RakutenOrderNumber $orderNumber               楽天注文番号 ValueObject
     * @param OrderProgress      $orderProgress             注文進捗ステータス Enum
     * @param int|null           $subStatusId               サブステータスID
     * @param int|null           $subStatusName             サブステータス名ID（仕様に応じて）
     * @param DateTime           $orderDatetime             注文日時
     * @param DateTime|null      $shopOrderCfmDatetime      店舗側注文確認日時
     * @param DateTime|null      $orderFixDatetime          注文確定日時
     * @param DateTime|null      $shippingInstDatetime      出荷指示日時
     * @param DateTime|null      $shippingCmplRptDatetime   出荷完了報告日時
     * @param DateTime|null      $cancelDueDate             キャンセル期限日
     * @param DateTime|null      $deliveryDate              お届け希望日
     * @param int|null           $shippingTerm              配送リードタイム（目安日数 等）
     * @param string|null        $remarks                   店舗メモ（備考）
     * @param int                $giftCheckFlag             ギフトチェックフラグ
     * @param int                $socialGiftFlag            ソーシャルギフトフラグ
     * @param int                $severalSenderFlag         複数送付先フラグ
     * @param int                $equalSenderFlag           送付元＝注文者フラグ
     * @param int                $isolatedIslandFlag        離島フラグ
     * @param int                $rakutenMemberFlag         楽天会員フラグ
     * @param int                $carrierCode               キャリアコード
     * @param int                $emailCarrierCode          メールキャリアコード
     * @param int                $orderType                 注文種別
     * @param string|null        $reserveNumber             予約番号
     * @param int|null           $reserveDeliveryCount      予約配送回数
     * @param int|null           $cautionDisplayType        注意表示種別
     * @param int|null           $cautionDisplayDetailType  注意表示詳細種別
     * @param int                $rakutenConfirmFlag        楽天側確認フラグ
     * @param int                $goodsPrice                商品金額合計（税抜）
     * @param int                $postagePrice              送料
     * @param int                $deliveryPrice             配送手数料
     * @param int                $paymentCharge             決済手数料
     * @param float              $paymentChargeTaxRate      決済手数料に対する税率
     * @param int                $totalPrice                注文合計金額（税込）
     * @param int                $requestPrice              請求金額
     * @param int                $couponAllTotalPrice       クーポン値引き合計
     * @param int                $couponShopPrice           店舗負担クーポン額
     * @param int                $couponOtherPrice          その他クーポン額
     * @param int                $additionalFeeOccurAmountToUser ユーザー追加請求額
     * @param int                $additionalFeeOccurAmountToShop 店舗負担追加額
     * @param int                $asurakuFlag               あす楽フラグ
     * @param int                $drugFlag                  医薬品フラグ
     * @param int                $dealFlag                  取引種別フラグ
     * @param int                $membershipType            会員種別
     * @param string|null        $memo                      店舗内部メモ
     * @param string|null        $operator                  担当オペレーター
     * @param string|null        $mailPlugSentence          メールプラグ文言
     * @param int                $modifyFlag                変更フラグ
     * @param int                $receiptIssueCount         領収書発行回数
     * @param DateTime[]         $receiptIssueHistoryList   領収書発行履歴日時リスト
     * @param Orderer            $OrdererModel              注文者情報 DTO
     * @param Settlement|null    $SettlementModel           決済情報 DTO
     * @param Delivery           $DeliveryModel             配送方法情報 DTO
     * @param Point|null         $PointModel                ポイント利用情報 DTO
     * @param Wrapping|null      $WrappingModel1            ラッピング情報1 DTO
     * @param Wrapping|null      $WrappingModel2            ラッピング情報2 DTO
     * @param Package[]          $PackageModelList          パッケージ（配送バスケット）DTO 配列
     * @param Coupen[]|null      $CouponModelList           クーポン情報 DTO 配列
     * @param ChangeReason[]|null $ChangeReasonModelList    変更理由 DTO 配列
     * @param TaxSummary[]|null  $TaxSummaryModelList       税サマリ DTO 配列
     * @param DueDate[]|null     $DueDateModelList          期限日情報 DTO 配列
     * @param int                $deliveryCertPrgFlag       お届け完了確認プログラムフラグ
     * @param int                $oneDayOperationFlag       1日運用フラグ
     */
    protected function __construct(
        public RakutenOrderNumber $orderNumber,
        public OrderProgress $orderProgress,
        public ?int $subStatusId,
        public ?int $subStatusName,
        public DateTime $orderDatetime,
        public ?DateTime $shopOrderCfmDatetime,
        public ?DateTime $orderFixDatetime,
        public ?DateTime $shippingInstDatetime,
        public ?DateTime $shippingCmplRptDatetime,
        public ?DateTime $cancelDueDate,
        public ?DateTime $deliveryDate,
        public ?int $shippingTerm,
        public ?string $remarks,
        public int $giftCheckFlag,
        public ?int $socialGiftFlag,
        public int $severalSenderFlag,
        public int $equalSenderFlag,
        public int $isolatedIslandFlag,
        public int $rakutenMemberFlag,
        public int $carrierCode,
        public int $emailCarrierCode,
        public int $orderType,
        public ?string $reserveNumber,
        public ?int $reserveDeliveryCount,
        public ?int $cautionDisplayType,
        public ?int $cautionDisplayDetailType,
        public int $rakutenConfirmFlag,
        public int $goodsPrice,
        public int $postagePrice,
        public int $deliveryPrice,
        public int $paymentCharge,
        public float $paymentChargeTaxRate,
        public int $totalPrice,
        public int $requestPrice,
        public int $couponAllTotalPrice,
        public int $couponShopPrice,
        public int $couponOtherPrice,
        public int $additionalFeeOccurAmountToUser,
        public int $additionalFeeOccurAmountToShop,
        public int $asurakuFlag,
        public int $drugFlag,
        public int $dealFlag,
        public int $membershipType,
        public ?string $memo,
        public ?string $operator,
        public ?string $mailPlugSentence,
        public int $modifyFlag,
        public int $receiptIssueCount,
        public array $receiptIssueHistoryList,
        public Orderer $OrdererModel,
        public ?Settlement $SettlementModel,
        public Delivery $DeliveryModel,
        public ?Point $PointModel,
        public ?Wrapping $WrappingModel1,
        public ?Wrapping $WrappingModel2,
        public array $PackageModelList,
        public ?array $CouponModelList,
        public ?array $ChangeReasonModelList,
        public ?array $TaxSummaryModelList,
        public ?array $DueDateModelList,
        public int $deliveryCertPrgFlag,
        public int $oneDayOperationFlag,
    ) {}
}
