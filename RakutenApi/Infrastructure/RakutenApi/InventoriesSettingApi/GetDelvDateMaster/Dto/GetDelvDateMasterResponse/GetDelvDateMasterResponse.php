<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse;

use ApiDto\BaseResponseDto\BaseResponseDto;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\DelvDateResult\DelvDateResult;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetDelvDateMaster\Dto\GetDelvDateMasterResponse\ResultMessageList\ResultMessageList;

/**
 * 在庫設定API（GetDelvDateMaster）レスポンスDTO
 *
 * 楽天RMSの配送日マスタ取得APIのレスポンスを表現するDTO。
 * BaseResponseDto を継承し、配列要素のDTO変換（子要素マッピング）をサポートする。
 *
 * 主な構成:
 * - resultCode: API実行結果コード（成功/失敗）
 * - resultMessageList: メッセージ一覧（エラー・警告など）
 * - result: 配送日マスタ情報（存在しない場合は null）
 */
readonly class GetDelvDateMasterResponse extends BaseResponseDto{


    /**
     * @param string $resultCode API実行結果コード
     * @param ResultMessageList $resultMessageList メッセージ一覧
     * @param DelvDateResult|null $result 配送日マスタ情報
     */
    public function __construct(
        public string $resultCode,
        public ResultMessageList $resultMessageList,
        public ?DelvDateResult $result
    )
    {}
}

if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){
    $xml = <<<XML
        <shopbiz:shopBizApiResponse xmlns:shopbiz="http://rakuten.co.jp/rms/mall/shop/biz/api/model/resource">
            <resultCode>N000</resultCode>
            <resultMessageList>
                <resultMessage>
                    <code>N000</code>
                    <message>Succeeded.</message>
                </resultMessage>
            </resultMessageList>
            <result xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="shopbiz:delvdateMasterBizModel">
                <delvdateMasterList>
                    <delvdateMaster>
                        <delvdateNumber>0</delvdateNumber>
                        <delvdateCaption>testDateCaption</delvdateCaption>
                    </delvdateMaster>
                    <delvdateMaster>
                        <delvdateNumber>1</delvdateNumber>
                        <delvdateCaption>当日お届けします。</delvdateCaption>
                    </delvdateMaster>
                    <delvdateMaster>
                        <delvdateNumber>1000</delvdateNumber>
                        <delvdateCaption>1〜2日以内に発送予定（店舗休業日を除く）</delvdateCaption>
                    </delvdateMaster>
                    <delvdateMaster>
                        <delvdateNumber>2</delvdateNumber>
                        <delvdateCaption>３〜4日でのお届けとなります。</delvdateCaption>
                    </delvdateMaster>
                    <delvdateMaster>
                        <delvdateNumber>3</delvdateNumber>
                        <delvdateCaption>一週間前後でのお届けとなります。</delvdateCaption>
                    </delvdateMaster>
                </delvdateMasterList>
            </result>
        </shopbiz:shopBizApiResponse>
    XML;
    $xmlObj = simplexml_load_string($xml);

    $data = json_decode(json_encode($xmlObj),true);
    var_dump(GetDelvDateMasterResponse::fromResponse($data));


    // echo json_encode($xmlObj,384);
}
