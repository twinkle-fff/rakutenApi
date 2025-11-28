<?php
namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\SearchOrder;

use BadMethodCallException;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\Enum\OrderProgress;

/**
 * 楽天受注API用の検索パラメータDTO。
 *
 * - コンストラクタで必須項目（dateType, startDatetime, endDatetime）を受け取る
 * - 任意項目は setter もしくは __call / set() で柔軟に設定
 * - toArray() 実行時に、楽天API仕様に沿った配列構造へ変換される
 *   - OrderProgress / OrderProgress[] は value へ変換
 *   - ページネーション関連は PaginationRequestModel の下にネスト
 */
class SearchOrderParams
{
    /**
     * 1回のリクエストで取得する受注最大件数のデフォルト値。
     */
    private const DEFAULT_ORDER_RECORDS = 1000;

    private const string PAGINATION_MODEL_KEY = 'PaginationRequestModel';

    private const array PAGINATION_MAP = [
        'requestRecordsAmount' => 'requestRecordsAmount',
        'requestPage'          => 'requestPage',
    ];

    /**
     * 受注ステータスリスト。
     *
     * @var OrderProgress[]|null
     */
    private ?array $orderProgressList = null;

    /**
     * サブステータスIDリスト。
     *
     * @var int[]|null
     */
    private ?array $subStatusIdList = null;

    /**
     * 期間検索種別。
     * 楽天仕様に沿ったint値（例: 注文日、出荷日などの種別）。
     */
    private int $dateType;

    /**
     * 検索開始日時（"Y-m-d\TH:i:s+0900" 形式の文字列）。
     */
    private string $startDatetime;

    /**
     * 検索終了日時（"Y-m-d\TH:i:s+0900" 形式の文字列）。
     */
    private string $endDatetime;

    /**
     * 注文タイプリスト。
     *
     * @var int[]|null
     */
    private ?array $orderTypeList = null;

    /** 決済方法。 */
    private ?int $settlementMethod = null;

    /** 配送方法名。 */
    private ?string $deliveryName = null;

    /** 出荷日未設定フラグ。 */
    private ?int $shippingDateBlankFlag = null;

    /** 伝票番号未設定フラグ。 */
    private ?int $shippingNumberBlankFlag = null;

    /** キーワード検索種別。 */
    private ?int $searchKeywordType = null;

    /** キーワード。 */
    private ?string $searchKeyword = null;

    /** メール送信種別。 */
    private ?int $mailSendType = null;

    /** 注文者メールアドレス。 */
    private ?string $ordererMailAddress = null;

    /** 電話番号種別。 */
    private ?int $phoneNumberType = null;

    /** 電話番号。 */
    private ?string $phoneNumber = null;

    /** 予約番号。 */
    private ?string $reserveNumber = null;

    /** 購入サイト種別。 */
    private ?int $purchaseSiteType = null;

    /** あす楽フラグ。 */
    private ?int $asurakuFlag = null;

    /** クーポン利用フラグ。 */
    private ?int $couponUseFlag = null;

    /** 医薬品フラグ。 */
    private ?int $drugFlag = null;

    /** 海外フラグ。 */
    private ?int $overseasFlag = null;

    /** 日次処理フラグ。 */
    private ?int $oneDayOperationFlag = null;

    /**
     * 1ページあたり取得件数。
     * toArray() 時には PaginationRequestModel['requestRecordsAmount'] にマッピングされる。
     */
    private int $requestRecordsAmount;

    /**
     * 取得ページ番号。
     * toArray() 時には PaginationRequestModel['requestPage'] にマッピングされる。
     */
    private ?int $requestPage = null;

    /**
     * 必須パラメータはコンストラクタで受け取る。
     *
     * @param int                          $dateType             期間検索種別（必須）
     * @param int|string|DateTimeInterface $startDatetime        期間検索開始日時
     *                                                            - int: UNIXタイムスタンプ
     *                                                            - string: DateTimeImmutable に解釈可能な文字列
     *                                                            - DateTimeInterface: そのまま日時オブジェクト
     * @param int|string|DateTimeInterface $endDatetime          期間検索終了日時
     * @param int|null                     $requestRecordsAmount 1ページあたりの取得件数（未指定時は DEFAULT_ORDER_RECORDS）
     *
     * @throws InvalidArgumentException 入力日時が不正な場合
     */
    public function __construct(
        int $dateType,
        int|string|DateTimeInterface $startDatetime,
        int|string|DateTimeInterface $endDatetime,
        ?int $requestRecordsAmount = null
    ) {
        $this->dateType              = $dateType;
        $this->startDatetime         = $this->castISO($startDatetime);
        $this->endDatetime           = $this->castISO($endDatetime);
        $this->requestRecordsAmount  = $requestRecordsAmount ?? self::DEFAULT_ORDER_RECORDS;
    }

    /**
     * 与えられた日時を "Y-m-d\TH:i:s+0900" 形式の文字列に正規化する。
     *
     * - int の場合: UNIXタイムスタンプとして扱う
     * - string の場合: new DateTimeImmutable($datetime) で解釈できる前提
     * - DateTimeInterface の場合: そのままの値をベースに新しい DateTimeImmutable を作成
     *
     * 全て最終的に Asia/Tokyo(+0900) に変換した上でフォーマットする。
     *
     * @param string|int|DateTimeInterface $datetime
     * @return string "Y-m-d\TH:i:s+0900" 形式
     *
     * @throws InvalidArgumentException 不正な日時文字列が渡された場合
     */
    private function castISO(string|int|DateTimeInterface $datetime): string
    {
        if (\is_int($datetime)) {
            $datetime = new DateTimeImmutable('@' . $datetime);
        } elseif (\is_string($datetime)) {
            try {
                $datetime = new DateTimeImmutable($datetime);
            } catch (Exception $e) {
                throw new InvalidArgumentException("入力された日時形式が不正です。 '{$datetime}'");
            }
        } elseif ($datetime instanceof DateTimeInterface) {
            $datetime = new DateTimeImmutable($datetime->format('c'));
        }

        return $datetime
            ->setTimezone(new \DateTimeZone('Asia/Tokyo'))
            ->format('Y-m-d\TH:i:s+0900');
    }

    /**
     * オブジェクトの状態を楽天APIに渡すための配列形式に変換する。
     *
     * - プロパティ名をキーとして展開
     * - OrderProgress / OrderProgress[] は value に変換
     * - requestRecordsAmount / requestPage は
     *   PaginationRequestModel 配下にまとめてネストする
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        foreach (get_object_vars($this) as $property => $value) {
            // PaginationRequestModel 判定
            if (array_key_exists($property, self::PAGINATION_MAP)) {
                $result[self::PAGINATION_MODEL_KEY][self::PAGINATION_MAP[$property]] = $value;
                continue;
            }

            if (is_array($value)) {
                $converted = [];
                foreach ($value as $item) {
                    $converted[] = $item instanceof OrderProgress ? $item->value : $item;
                }
                $result[$property] = $converted;
                continue;
            }

            if ($value instanceof OrderProgress) {
                $result[$property] = $value->value;
                continue;
            }

            $result[$property] = $value;
        }

        return $result;
    }

    /**
     * 動的 setter: set{PropertyName}($value) 形式で各プロパティにセットできるようにする。
     *
     * 例:
     *   $params->setSettlementMethod(1);
     *   $params->setOrderTypeList([1, 2, 3]);
     *
     * @param string $name      呼び出されたメソッド名
     * @param array  $arguments 引数配列（通常は1つだけ想定）
     *
     * @return self
     *
     * @throws BadMethodCallException    "set" で始まらないメソッド呼び出し時
     * @throws InvalidArgumentException  存在しないプロパティを指定した場合
     */
    public function __call(string $name, array $arguments): self
    {
        if (\strncmp($name, 'set', 3) !== 0) {
            throw new BadMethodCallException("未定義メソッド: {$name}");
        }

        $property = \lcfirst(\substr($name, 3));

        if (!\property_exists($this, $property)) {
            throw new InvalidArgumentException("存在しないプロパティ: {$property}");
        }

        $value = $arguments[0] ?? null;
        $this->{$property} = $value;

        return $this;
    }

    /**
     * 直接キーを指定してプロパティをセットするためのユーティリティ。
     *
     * 例:
     *   $params->set('settlementMethod', 1);
     *
     * @param string $key   プロパティ名
     * @param mixed  $value 設定する値
     *
     * @return self
     *
     * @throws InvalidArgumentException 存在しないプロパティを指定した場合
     */
    public function set(string $key, mixed $value): self
    {
        if (!\property_exists($this, $key)) {
            throw new InvalidArgumentException("存在しないプロパティ: {$key}");
        }

        $this->{$key} = $value;

        return $this;
    }

    /**
     * 配列から SearchOrderParams インスタンスを生成する。
     *
     * 必須キー:
     * - dateType
     * - startDatetime
     * - endDatetime
     *
     * 任意キー:
     * - クラスに対応するプロパティが存在するものは全てセット対象
     * - orderProgressList は OrderProgress / ラベル / 値 いずれからでも解決
     *
     * @param array $data 入力配列
     *
     * @return self
     *
     * @throws InvalidArgumentException 必須キー不足、または存在しないキーが含まれる場合
     */
    public static function fromArray(array $data): self
    {
        foreach (['dateType', 'startDatetime', 'endDatetime'] as $requiredKey) {
            if (!\array_key_exists($requiredKey, $data)) {
                throw new InvalidArgumentException("必須キーが不足しています: {$requiredKey}");
            }
        }

        $instance = new self(
            (int)$data['dateType'],
            $data['startDatetime'],
            $data['endDatetime']
        );

        foreach ($data as $key => $value) {
            if ($key === 'dateType' || $key === 'startDatetime' || $key === 'endDatetime') {
                continue;
            }

            if ($key === 'orderProgressList') {
                if ($value === null) {
                    $instance->orderProgressList = null;
                    continue;
                }

                $list = [];
                if (\is_array($value)) {
                    foreach ($value as $raw) {
                        $list[] = self::normalizeOrderProgress($raw);
                    }
                } else {
                    $list[] = self::normalizeOrderProgress($value);
                }

                $instance->orderProgressList = $list;
                continue;
            }

            if (!\property_exists($instance, $key)) {
                throw new InvalidArgumentException("fromArray に不正なキーが含まれています: {$key}");
            }

            $instance->{$key} = $value;
        }

        return $instance;
    }

    /**
     * OrderProgress を、値 / ラベル / 既に Enum のいずれからでも解決する。
     *
     * 優先順位:
     *  1. OrderProgress::tryFrom()
     *  2. OrderProgress::fromLabel()
     *
     * tryFrom が例外を投げる実装になっている場合でも、
     * 例外を握りつぶして fromLabel にフォールバックする。
     *
     * @param mixed $raw 生の値（int|string|OrderProgress）
     *
     * @return OrderProgress
     */
    private static function normalizeOrderProgress(mixed $raw): OrderProgress
    {
        if ($raw instanceof OrderProgress) {
            return $raw;
        }

        $progress = null;

        try {
            $progress = OrderProgress::tryFrom($raw);
        } catch (\Throwable $e) {
            $progress = null;
        }

        if ($progress instanceof OrderProgress) {
            return $progress;
        }

        return OrderProgress::fromLabel((string)$raw);
    }
}
