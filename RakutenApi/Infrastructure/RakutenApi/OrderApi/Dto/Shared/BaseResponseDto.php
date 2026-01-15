<?php

namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Dto\Shared;

use BackedEnum;
use DateTime;
use DateTimeInterface;
use Exception;
use ReflectionClass;
use ReflectionNamedType;
use RakutenApi\Infrastructure\RakutenApi\OrderApi\ValueObject\RakutenOrderNumber;

readonly abstract class BaseResponseDto
{
    protected function __construct(...$args) {}

    /** @var array<string, class-string> */
    protected const array ARRAY_CHILD_MAP = [];

    protected const string CLASS_LABEL = '楽天APIレスポンス';

    /**
     * @param array<string,mixed> $response
     * @return static
     * @throws Exception
     */
    public static function fromResponse(array $response): static
    {
        $reflection = new ReflectionClass(static::class);
        $props      = $reflection->getProperties();

        $args = [];

        foreach ($props as $prop) {
            $name = $prop->getName();
            $type = $prop->getType();

            if (!$type instanceof ReflectionNamedType) {
                $args[$name] = $response[$name] ?? null;
                continue;
            }

            $allowsNull = $type->allowsNull();
            $typeName   = $type->getName();

            if (!$allowsNull && !array_key_exists($name, $response)) {
                throw new Exception(
                    static::CLASS_LABEL . "の取得に失敗しました。必須キー {$name} が不足しています。"
                );
            }

            if (!array_key_exists($name, $response)) {
                $args[$name] = null;
                continue;
            }

            $rawValue = $response[$name];

            if ($rawValue === null && $allowsNull) {
                $args[$name] = null;
                continue;
            }

            $args[$name] = static::normalizeKey($name, $rawValue, $typeName);
        }

        /** @phpstan-ignore-next-line */
        return new static(...$args);
    }

    /**
     * @throws Exception
     */
    protected static function normalizeKey(string $key, mixed $value, string $type): mixed
    {
        try {
            // ✅【最優先】単体子DTO（BaseResponseDto継承）なら必ずDTO化（autoload込み）
            if (is_array($value) && is_subclass_of($type, self::class, true)) {
                /** @var class-string<self> $type */
                return $type::fromResponse($value);
            }

            // BackedEnum
            if (enum_exists($type) && is_subclass_of($type, BackedEnum::class)) {
                /** @var class-string<BackedEnum> $type */
                $enum = $type::tryFrom($value);
                if ($enum === null) {
                    throw new Exception("Enum {$type} に値 {$value} をマッピングできません。");
                }
                return $enum;
            }

            return match ($type) {
                'string' => (string)$value,
                'int'    => (int)$value,
                'float'  => (float)$value,
                'bool'   => (bool)$value,
                DateTime::class => new DateTime((string)$value),
                RakutenOrderNumber::class => new RakutenOrderNumber((string)$value),
                default  => static::applyChildModel($key, $value, $type),
            };
        } catch (Exception $e) {
            throw new Exception(
                static::CLASS_LABEL . "の取得に失敗しました。{$key} の変換に失敗しました。詳細: {$e->getMessage()}",
                (int)$e->getCode(),
                $e
            );
        }
    }

    /**
     * @throws Exception
     */
    protected static function applyChildModel(string $key, mixed $value, string $type): mixed
    {
        // 🟦 単体DTO（valueが配列なら DTO化）※autoload込み
        if (is_subclass_of($type, self::class, true)) {
            if ($value instanceof $type) {
                return $value;
            }
            if (is_array($value)) {
                /** @var class-string<self> $type */
                return $type::fromResponse($value);
            }
            return $value;
        }

        /** @var array<string, class-string> $map */
        $map = static::ARRAY_CHILD_MAP ?? [];

        // 🟩 配列（DTO配列 / DateTime配列）※ assocキー維持
        if ($type === 'array' && isset($map[$key]) && is_array($value)) {
            $elemType = $map[$key];

            // DateTime配列
            if (is_a($elemType, DateTimeInterface::class, true)) {
                $out = [];
                foreach ($value as $k => $v) {
                    $out[$k] = new DateTime((string)$v);
                }
                return $out;
            }

            // DTO配列（autoload込み）
            if (is_subclass_of($elemType, self::class, true)) {
                $out = [];
                foreach ($value as $k => $v) {
                    /** @var class-string<self> $elemType */
                    $out[$k] = $elemType::fromResponse($v);
                }
                return $out;
            }
        }

        return $value;
    }
}
