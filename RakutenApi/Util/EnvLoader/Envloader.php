<?php
namespace RakutenApi\Util\EnvLoader;

use Dotenv\Dotenv;
use Exception;

class Envloader{
    private const string DEFAULT_FILENAME = ".env.local";
    private static ?string $envFilePath = null;
    private static ?string $envFileName = null;
    private static ?Dotenv $dotenv = null;

    public static function getEnv(string $key, ?string $envFilePath = null, ?string $envFileName = null){
        self::loadEnv($envFilePath,$envFileName);

        $value = $_ENV[$key] ?? ($_SERVER[$key] ?? null);
        if($value == null){
            throw new Exception("環境変数の取得に失敗しました。環境変数{$key}が見つかりません。");

        }
        return $value;
    }


    private static function loadEnv(?string $envFilePath, ?string $envFileName){
        $envFilePath ??= getcwd();
        $envFileName ??= self::DEFAULT_FILENAME;
        if(self::$dotenv !== null && $envFilePath == self::$envFilePath && $envFileName != self::$envFileName ){
            return;
        }
        try{
            $dotenv = Dotenv::createImmutable($envFilePath,$envFileName);
            $dotenv->load();
            self::$dotenv = $dotenv;
        }catch(Exception $e){
            throw new Exception("環境変数ファイルの取得に失敗しました。detail:{$e->getMessage()}",$e->getCode(),$e);
        }
    }
}
