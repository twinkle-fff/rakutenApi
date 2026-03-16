<?php
namespace RakutenApi\Application\Port\RakutenApi;

use RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Dto\GetFolder\Folder;
use RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Dto\InsertImage\InsertImageParams;

/**
 * RMS R-Cabinet API へのアクセスを抽象化した Port。
 *
 * Application 層から Infrastructure 層の具体実装へ依存しないための窓口。
 *
 * 主に以下の責務を持つ:
 * - キャビネット内フォルダ一覧の取得
 * - 画像ファイルのアップロード
 */
interface R_CabinetPort
{
    /**
     * RMSキャビネット内のフォルダ一覧を取得する。
     *
     * 実装側では、必要に応じてページングを繰り返し、
     * 最終的に全件を返してよい。
     *
     * @param int|null $limit
     *  1回のAPI呼び出しで取得する件数。
     *  null の場合は実装側のデフォルト値を使用する。
     *
     * @return Folder[]
     *  取得したフォルダDTOの配列
     */
    public function getFolders(?int $limit = null): array;

    /**
     * RMSキャビネットへ画像をアップロードする。
     *
     * 第1引数には連想配列、または DTO を受け付ける。
     * 連想配列が渡された場合は、実装側で DTO へ正規化して処理する。
     *
     * @param array|InsertImageParams $imagePrams
     *  画像登録時のリクエストパラメータ。
     *  想定キーは InsertImageParams::fromArray() に準ずる。
     *
     * @param string $imagePath
     *  アップロード対象画像の絶対パスまたは実行環境から解決可能なファイルパス。
     *
     * @return string|bool
     *  成功時は登録された FileId を返す。
     *  取得できなかった場合は false を返す。
     */
    public function insertImage(array|InsertImageParams $imagePrams, string $imagePath): string|bool;
}
