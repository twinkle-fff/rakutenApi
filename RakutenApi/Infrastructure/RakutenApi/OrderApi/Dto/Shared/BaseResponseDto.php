<?php

namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared;

use DateTime;
use Exception;
use ReflectionClass;
use ReflectionNamedType;
use BackedEnum;
use DateTimeInterface;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;

/**
 * 楽天APIレスポンス用 DTO の共通基底クラス。
 *
 * - Reflection を用いてコンストラクタ引数にマッピング
 * - プロパティ型に応じて値を正規化（string/int/float/DateTime/子DTO）
 * - 必須キー不足時に例外をスロー
 *
 * 子クラス側は:
 *   - readonly
 *   - private コンストラクタ
 *   - public プロパティ
 * のみ定義し、fromResponse() はこのクラスを継承して使う。
 */
readonly abstract class BaseResponseDto
{

    protected function __construct(...$args)
    {
    }

    protected const array ARRAY_CHILD_MAP = [];

    protected const CLASS_LABEL = '楽天APIレスポンス';

    /**
     * APIレスポンス配列から DTO インスタンスを生成する。
     *
     * @param array<string,mixed> $response
     * @return static
     * @throws Exception 必須キー不足、または型変換・日時パース失敗時
     */
    public static function fromResponse(array $response): static
    {
        $reflection = new ReflectionClass(static::class);
        $props      = $reflection->getProperties();

        $args = [];

        foreach ($props as $prop) {
            $name = $prop->getName();
            $type = $prop->getType();

            // 型が付いていない場合はそのまま or null
            if (!$type instanceof ReflectionNamedType) {
                $args[$name] = $response[$name] ?? null;
                continue;
            }

            $allowsNull = $type->allowsNull();
            $typeName   = $type->getName();

            // null 不可なのにキーがない → エラー
            if (!$allowsNull && !array_key_exists($name, $response)) {
                throw new Exception(
                    static::CLASS_LABEL . "の取得に失敗しました。必須キー {$name} が不足しています。"
                );
            }

            // キーがなくて null 許可 → null
            if (!array_key_exists($name, $response)) {
                $args[$name] = null;
                continue;
            }

            $rawValue = $response[$name];

            // null 許可で実際に null → そのまま
            if ($rawValue === null && $allowsNull) {
                $args[$name] = null;
                continue;
            }

            // 型に応じて正規化
            $args[$name] = static::normalizeKey($name, $rawValue, $typeName);
        }

        // 引数はプロパティ順に渡す前提（readonly + private __construct）

        /** @phpstan-ignore-next-line */
        return new static(...$args);
    }

    /**
     * 子モデル（ネストした DTO）を適用する。
     *
     * @param string $key   プロパティ名
     * @param mixed  $value レスポンス中の生の値
     * @param string $type  型名（FQCNを含む可能性あり）
     *
     * @return mixed
     * @throws Exception
     */
    protected static function applyChildModel(string $key, mixed $value, string $type): mixed
    {
        // 🟦 単体の子DTO（BaseResponseDto 継承クラス）
        if (is_array($value) && is_subclass_of($type, self::class)) {
            /** @var class-string<self> $type */
            return $type::fromResponse($value ?? []);
        }

        /** @var array<string, class-string> $map */
        $map = static::ARRAY_CHILD_MAP ?? [];

        // 🟩 配列プロパティ（DTO配列 or DateTime配列など）
        if ($type === 'array' && isset($map[$key]) && is_array($value)) {
            $listType = $map[$key];
            // ① 配列要素が DateTimeInterface 実装クラスの場合
            if (is_a($listType, DateTimeInterface::class, true)) {
                return array_map(
                    function ($n) use ($listType) {
                        return new DateTime((string)$n);
                    },
                    $value
                );
            }

            // ② 配列要素が BaseResponseDto の子クラスの場合（Item, Shipping 等）
            if (is_subclass_of($listType, self::class)) {
                return array_map(
                    function ($n) use ($listType) {
                        /** @var class-string<self> $listType */
                        return $listType::fromResponse($n);
                    },
                    $value
                );
            }
        }

        // 🟨 それ以外はそのまま返す
        return $value;
    }
    /**
     * プロパティ型に応じてレスポンス値を正規化する。
     *
     * @param string $key   プロパティ名
     * @param mixed  $value レスポンス中の生の値
     * @param string $type  型名（string/int/float/DateTime/FQCNなど）
     *
     * @return mixed
     * @throws Exception
     */
    protected static function normalizeKey(string $key, mixed $value, string $type): mixed
    {
        try {
            // 🟦 まず BackedEnum（DeliveryCompany 含む）を優先的に処理
            if (enum_exists($type) && is_subclass_of($type, BackedEnum::class)) {
                /** @var class-string<BackedEnum> $type */
                $enum = $type::tryFrom($value);

                if ($enum === null) {
                    throw new Exception("Enum {$type} に値 {$value} をマッピングできません。");
                }

                return $enum;
            }

            return match ($type) {
                'string'        => (string)$value,
                'int'           => (int)$value,
                'float'         => (float)$value,
                DateTime::class => new DateTime((string)$value),
                RakutenOrderNumber::class => new RakutenOrderNumber((string)$value),
                default         => static::applyChildModel($key, $value, $type),
            };
        } catch (Exception $e) {
            throw new Exception(
                static::CLASS_LABEL . "の取得に失敗しました。{$key} の変換に失敗しました。詳細: {$e->getMessage()}",
                (int)$e->getCode(),
                $e
            );
        }
    }
}
