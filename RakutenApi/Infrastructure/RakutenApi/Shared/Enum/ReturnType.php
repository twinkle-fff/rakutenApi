<?php
namespace RakutenApi\Infrastructure\RakutenApi\Shared\Enum;

/**
 * レスポンスの返却形式を表す列挙型。
 *
 * 楽天 API クライアントや内部処理で、
 * 「レスポンスをどの形式で扱うか」を明確に指定するために使用する。
 *
 * 値は API や HTTP クライアントがそのまま利用できるよう、
 * 実際の文字列表現（"text" / "json" / "xml"）を保持する。
 *
 * 利用例:
 *
 * ```php
 * $type = ReturnType::JSON;
 * $client->request($url, params: [], returnType: $type);
 * ```
 *
 * 文字列 → Enum へ柔軟に変換したい場合は:
 *
 * ```php
 * $type = ReturnType::tryFrom($raw) ?? ReturnType::JSON;
 * ```
 *
 * @see ReturnType::tryFrom()
 */
enum ReturnType: string
{
    /** プレーンテキスト形式で返却 */
    case TEXT = "text";

    /** JSON 形式で返却 */
    case JSON = "json";

    /** XML 形式で返却 */
    case XML = "xml";
}
