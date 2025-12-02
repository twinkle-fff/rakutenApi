<?php
namespace RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Enum;

/**
 * 画像の上書き動作を指定するフラグ。
 *
 * 楽天 RMS「cabinet.file.upload」等で画像をアップロードする際に、
 * 既存ファイルと同名だった場合にどの挙動を取るかを指定する。
 *
 * - OVER_WRITE（"true"）
 *     既存ファイルを上書きして置き換える。
 *     同名ファイルがすでに存在していても新しいファイルで強制的に更新される。
 *
 * - INSERT（"false"）
 *     上書きせず、新規ファイルとして登録する。
 *     RMS 側で自動的に連番が付与される（例：image.jpg → image_1.jpg）。
 *
 * @enum
 */
enum ImageOverWrite: string
{
    /** 既存の画像を上書きしてアップロードする ("true") */
    case OVER_WRITE = "true";

    /** 上書きせず新規画像としてアップロードする ("false") */
    case INSERT = "false";
}
