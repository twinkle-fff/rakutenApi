<?php

namespace RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Dto\InsertImage;

use Exception;
use RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Enum\ImageOverWrite;
use SimpleXMLElement;

/**
 * 画像登録 API（cabinet.file.insert）向けのリクエスト DTO。
 *
 * RMS Cabinet API に画像を登録する際に必要なパラメータを保持し、
 * XML リクエスト形式へ変換する責務を持つ。
 *
 * 主な利用フロー:
 *   $params = InsertImageParams::fromArray([...]);
 *   $xml = $params->toXML();
 *   → API クライアントで送信
 *
 * 必須項目:
 *   - fileName : 画像ファイル名（RMS 上での名前）
 *   - folderId : 登録先フォルダID
 *
 * 任意項目:
 *   - filePath  : サーバー上のファイル実体のパス
 *   - overWrite : 上書きするか（ImageOverWrite enum）
 *
 */
readonly class InsertImageParams
{
    /** @var string[] 必須のキー一覧 */
    private const array REQUIRED_PARAMS = [
        "fileName",
        "folderId",
    ];

    /**
     * @param string               $fileName   登録する画像の名前
     * @param int                  $folderId   登録先フォルダID
     * @param string|null          $filePath   アップロード対象ファイルのパス
     * @param ImageOverWrite|null  $overWrite  既存ファイルを上書きするかどうか
     */
    public function __construct(
        public string $fileName,
        public int $folderId,
        public ?string $filePath,
        public ?ImageOverWrite $overWrite
    ) {}

    /**
     * 配列から InsertImageParams を生成する。
     *
     * 使用例:
     *   $params = InsertImageParams::fromArray([
     *       "fileName" => "sample.jpg",
     *       "folderId" => 0,
     *       "filePath" => "/path/to/sample.jpg",
     *       "overWrite" => "true",
     *   ]);
     *
     * @param array $data 入力データ
     * @return InsertImageParams
     * @throws Exception 必須キーが不足している場合
     */
    public static function fromArray(array $data): InsertImageParams
    {
        foreach (self::REQUIRED_PARAMS as $requiredParam) {
            // ※ 現行コードにバグがあったため修正（isset($x) || null → 常に true ）
            if (!array_key_exists($requiredParam, $data)) {
                throw new Exception("画像登録リクエストの作成に失敗しました。必須キー {$requiredParam} がありません。");
            }
        }

        return new InsertImageParams(
            $data["fileName"],
            $data["folderId"],
            $data["filePath"] ?? null,
            isset($data["overWrite"]) ? ImageOverWrite::tryFrom($data["overWrite"]) : null,
        );
    }

    /**
     * RMS Cabinet API が要求する XML 形式に変換する。
     *
     * 出力例:
     *   <?xml version="1.0" encoding="UTF-8"?>
     *   <request>
     *       <fileInsertRequest>
     *           <file>
     *               <fileName>ZZZ</fileName>
     *               <folderId>0</folderId>
     *               <filePath>img136281.jpg</filePath>
     *               <overWrite>true</overWrite>
     *           </file>
     *       </fileInsertRequest>
     *   </request>
     *
     * @return string XML 文字列
     * @throws Exception XML 生成に失敗した場合
     */
    public function toXML(): string
    {
        $xml = new SimpleXMLElement('<request/>');
        $fileInsertRequest = $xml->addChild('fileInsertRequest');
        $file = $fileInsertRequest->addChild('file');

        $file->addChild('fileName', $this->fileName);
        $file->addChild('folderId', (string)$this->folderId);

        if ($this->filePath !== null) {
            $file->addChild('filePath', $this->filePath);
        }

        if ($this->overWrite !== null) {
            $file->addChild('overWrite', $this->overWrite->value);
        }

        $xmlString = $xml->asXML();

        if ($xmlString === false) {
            throw new Exception('画像登録リクエストXMLの生成に失敗しました。');
        }

        return $xmlString;
    }
}
