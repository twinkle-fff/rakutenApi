<?php

namespace RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Dto\GetFolder;

use DateTime;
use Exception;
use ReflectionClass;
use ReflectionNamedType;

/**
 * フォルダ情報を表すDTO。
 *
 * RMS R-Cabinet API から取得したフォルダ情報を安全に扱うための不変クラス（readonly）です。
 * `fromArray()` で配列からインスタンス化します。
 *
 * @property-read int      $FolderId     フォルダID
 * @property-read string   $FolderName   フォルダ名
 * @property-read int      $FolderNode   ノード階層
 * @property-read string   $FolderPath   パス（"root/子/孫" のような形式）
 * @property-read int      $FileCount    フォルダ内のファイル数
 * @property-read float    $FileSize     フォルダ内の総ファイルサイズ
 * @property-read DateTime $TimeStamp    最終更新日時
 */
readonly class Folder
{

    /**
     * @param int      $FolderId
     * @param string   $FolderName
     * @param int      $FolderNode
     * @param string   $FolderPath
     * @param int      $FileCount
     * @param float    $FileSize
     * @param DateTime $TimeStamp
     */
    private function __construct(
        public int $FolderId,
        public string $FolderName,
        public int $FolderNode,
        public string $FolderPath,
        public int $FileCount,
        public float $FileSize,
        public DateTime $TimeStamp
    ) {}

    /**
     * 配列から Folder インスタンスを生成する。
     *
     * 与えられた配列に必須キーがすべて含まれているかチェックし、
     * 型の不整合がある場合は Exception を投げます。
     *
     * @param array<string,mixed> $data フォルダ情報配列
     * @return Folder
     *
     * @throws Exception 必須キーが不足している場合
     */
    public static function fromArray(array $data): Folder
    {
        $ref   = new ReflectionClass(self::class);
        $props = $ref->getProperties();
        $args  = [];

        foreach ($props as $prop) {
            $key  = $prop->getName();
            $type = $prop->getType();

            // 必須チェック（0 や空文字は許容したいので array_key_exists を使う）
            if (!$type?->allowsNull() && !array_key_exists($key, $data)) {
                throw new Exception(
                    "フォルダ情報の取得に失敗しました。フォルダ情報に必須キー {$key} がありません。"
                );
            }

            $value = $data[$key] ?? null;

            // 型が DateTime の場合、文字列 → DateTime に変換
            if (
                $value !== null &&
                $type instanceof ReflectionNamedType &&
                $type->getName() === DateTime::class &&
                !$value instanceof DateTime
            ) {
                $value = new DateTime($value);
            }

            // コンストラクタ引数の順番に合わせて積んでいく
            $args[] = $value;
        }

        // プロパティ順 = 宣言順で引数を渡す
        return new self(...$args);
    }
}
