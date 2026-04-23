<?php
namespace RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse;
require_once __DIR__."/../../../../../../../vendor/autoload.php";
use ApiDto\BaseResponseDto\BaseResponseDto;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\OperationLeadTimeBizModel\OperationLeadTimeBizModel;
use RakutenApi\Infrastructure\RakutenApi\InventoriesSettingApi\GetOperationLeadTime\Dto\GetOperationLeadTimeResponse\ResultMessageModelList\ResultMessageModelList;

/**
 * 在庫設定API（GetOperationLeadTime）レスポンスDTO
 *
 * 出荷リードタイムマスタ取得APIのレスポンス全体を表現する。
 *
 * 主な構成:
 * - resultCode: API実行結果コード
 * - resultMessageList: メッセージ一覧
 * - result: 出荷リードタイム情報本体
 */
readonly class GetOperationLeadTimeResponse extends BaseResponseDto
{
    /**
     * @param string $resultCode API実行結果コード
     * @param ResultMessageModelList $resultMessageList メッセージ一覧
     * @param OperationLeadTimeBizModel|null $result 出荷リードタイム情報
     */
    public function __construct(
        public string $resultCode,
        public ResultMessageModelList $resultMessageList,
        public ?OperationLeadTimeBizModel $result
    ) {}
}


if(basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])){
    $xml = <<<XML
    <shopbiz:shopBizApiResponse xmlns:shopbiz="http://rakuten.co.jp/rms/mall/shop/biz/api/model/resource">
            <resultCode>N000</resultCode>
            <resultMessageList>
                <resultMessage>
                    <code>N000</code>
                    <message>Succeeded.</message>
                </resultMessage>
            </resultMessageList>
            <result xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="shopbiz:operationLeadTimeBizModel">
                <operationLeadTimeList>
                    <operationLeadTime>
                        <operationLeadTimeId>41</operationLeadTimeId>
                        <name>出荷リードタイム01</name>
                        <numberOfDays>1</numberOfDays>
                        <inStockDefaultFlag>1</inStockDefaultFlag>
                        <outOfStockDefaultFlag>1</outOfStockDefaultFlag>
                    </operationLeadTime>
                </operationLeadTimeList>
            </result>
        </shopbiz:shopBizApiResponse>
    XML;

    $data = simplexml_load_string($xml);
    $data = json_decode(json_encode($data),true);

    // die(json_encode($data,384));

    var_dump(GetOperationLeadTimeResponse::fromResponse($data));
}
