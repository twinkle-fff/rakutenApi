<?php
namespace RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Dto\GetFolder;

use Exception;
use ReflectionClass;

/**
 * 楽天Cabinet API「フォルダ一覧取得（cabinetFoldersGet）」レスポンスDTO。
 *
 * XML → array 変換されたデータを安全に扱うための ValueObject/DTO。
 * - resultCode: APIステータスコード
 * - folderAllCount: 全フォルダ数
 * - folderCount: 今回取得件数
 * - folders: Folder[] の配列（フォルダ一覧）
 *
 * @package RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Dto\GetFolder
 */
readonly class FolderResponse
{
    /**
     * @param int        $resultCode       APIの結果コード
     * @param int        $folderAllCount   全フォルダ数
     * @param int        $folderCount      今回取得したフォルダ数
     * @param Folder[]   $folders          フォルダ一覧
     */
    private function __construct(
        public int $resultCode,
        public int $folderAllCount,
        public int $folderCount,
        public array $folders
    ) {}

    /**
     * 生の配列から FolderResponse を生成するファクトリメソッド。
     *
     * @param array $data cabinetFoldersGetResult を想定した連想配列
     *
     * @return self
     *
     * @throws Exception 必須キーが不足している場合
     */
    public static function fromArray(array $data): self
    {
        $reflection = new ReflectionClass(self::class);
        $props = $reflection->getProperties();

        // 必須キー存在チェック
        foreach ($props as $prop) {
            $type = $prop->getType();
            $key = $prop->name;

            if (!$type->allowsNull() && !array_key_exists($key, $data)) {
                throw new Exception("フォルダ情報の取得に失敗しました。必須キー {$key} がありません。");
            }
        }

        return new self(
            $data["resultCode"],
            $data["folderAllCount"],
            $data["folderCount"],
            array_map(fn($n) => Folder::fromArray($n), $data["folders"]["folder"])
        );
    }

    /**
     * XMLレスポンス文字列から FolderResponse を生成する。
     *
     * 1. SimpleXML で XML → オブジェクト
     * 2. json_encode+decode で PHP配列に変換
     * 3. 必須キー（result → cabinetFoldersGetResult）を抽出
     *
     * @param string $XML APIレスポンスXML
     *
     * @return self
     *
     * @throws Exception XML解析失敗時 / 必須項目不足時
     */
    public static function fromXMLResponse(string $XML): self
    {
        $object = simplexml_load_string($XML);

        if ($object === false) {
            throw new Exception("XMLパースに失敗しました。");
        }

        $array = json_decode(json_encode($object), true);
        // cabinetFoldersGetResult の場所に依存
        // die(json_encode($array,JSON_PRETTY_PRINT));
        $content = $array["cabinetFoldersGetResult"] ?? [];

        if (empty($content)) {
            throw new Exception("フォルダ情報の取得に失敗しました。cabinetFoldersGetResult が空です。");
        }

        return self::fromArray($content);
    }
}
