<?php

namespace RakutenApi\Infrastructure\RakutenApi\OrderApi\Enum;

use InvalidArgumentException;

enum DeliveryCompany:int
{
    case OTHER                     = 1000;
    case YAMATO                    = 1001;
    case SAGAWA                    = 1002;
    case JAPAN_POST                = 1003;
    case SEINO                     = 1004;
    case SEINO_SPEX                = 1005;
    case FUKUYAMA_TSUSO            = 1006;
    case MEITETSU                  = 1007;
    case TONAMI                    = 1008;
    case DAIICHI_KAMOTSU           = 1009;
    case NIIGATA_UNYU              = 1010;
    case CHUETSU_UNSO              = 1011;
    case OKAYAMA_UNSO              = 1012;
    case KURUME_UNSO               = 1013;
    case SANYO_JIDOSHA_UNSO        = 1014;
    case NX_TRANSPORT              = 1015;
    case ECOPAI                    = 1016;
    case EMS                       = 1017;
    case DHL                       = 1018;
    case FEDEX                     = 1019;
    case UPS                       = 1020;
    case NITTSU                    = 1021;
    case TNT                       = 1022;
    case OCS                       = 1023;
    case USPS                      = 1024;
    case SF_EXPRESS                = 1025;
    case ARAMEX                    = 1026;
    case SGH_GLOBAL_JAPAN          = 1027;
    case RAKUTEN_EXPRESS           = 1028;
    case JAPAN_POST_RAKUTEN_WH     = 1029;
    case YAMATO_KURONEKO_YU_PACKET = 1030;
    case MEITETSU_NX               = 1031;

    /**
     * 配送会社名（日本語）を返す。
     */
    public function label(): string
    {
        return match ($this) {
            self::OTHER                     => 'その他',
            self::YAMATO                    => 'ヤマト運輸',
            self::SAGAWA                    => '佐川急便',
            self::JAPAN_POST                => '日本郵便',
            self::SEINO                     => '西濃運輸',
            self::SEINO_SPEX                => 'セイノースーパーエクスプレス',
            self::FUKUYAMA_TSUSO            => '福山通運',
            self::MEITETSU                  => '名鉄運輸',
            self::TONAMI                    => 'トナミ運輸',
            self::DAIICHI_KAMOTSU           => '第一貨物',
            self::NIIGATA_UNYU              => '新潟運輸',
            self::CHUETSU_UNSO              => '中越運送',
            self::OKAYAMA_UNSO              => '岡山県貨物運送',
            self::KURUME_UNSO               => '久留米運送',
            self::SANYO_JIDOSHA_UNSO        => '山陽自動車運送',
            self::NX_TRANSPORT              => 'NXトランスポート',
            self::ECOPAI                    => 'エコ配',
            self::EMS                       => 'EMS',
            self::DHL                       => 'DHL',
            self::FEDEX                     => 'FedEx',
            self::UPS                       => 'UPS',
            self::NITTSU                    => '日本通運',
            self::TNT                       => 'TNT',
            self::OCS                       => 'OCS',
            self::USPS                      => 'USPS',
            self::SF_EXPRESS                => 'SFエクスプレス',
            self::ARAMEX                    => 'Aramex',
            self::SGH_GLOBAL_JAPAN          => 'SGHグローバル・ジャパン',
            self::RAKUTEN_EXPRESS           => 'Rakuten EXPRESS',
            self::JAPAN_POST_RAKUTEN_WH     => '日本郵便 楽天倉庫出荷',
            self::YAMATO_KURONEKO_YU_PACKET => 'ヤマト運輸 クロネコゆうパケット',
            self::MEITETSU_NX               => '名鉄NX運輸',
        };
    }

    /**
     * 日本語ラベルから Enum を生成する。
     *
     * @param string $label
     * @return self
     *
     * @throws InvalidArgumentException 存在しないラベルの場合
     */
    public static function fromLabel(string $label): self
    {
        foreach (self::cases() as $case) {
            if ($case->label() === $label) {
                return $case;
            }
        }

        throw new InvalidArgumentException("DeliveryMethod: 不正なラベルです: {$label}");
    }
}
