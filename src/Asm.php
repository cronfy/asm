<?php

namespace cronfy\asm;

class Asm {

    public static $debug;
    public static $context;

    /**
     * Говорит, находится ли сейчас приложение в режиме разработки. Если нет,
     * то мы на боевом серере.
     *
     * @return bool
     */
    public static function isDebug() {
        if (!is_null(static::$debug)) {
            return static::$debug;
        } elseif (!is_null(static::$_env)) {
            return static::getEnv('ENVIRONMENT') == 'dev';
        }

        return false;
    }

    public static $vendorDir;
    public static function getVendorDir() {
//        return dirname(__DIR__) . '/../vendor';
        return static::$vendorDir ?: dirname(dirname(dirname(__DIR__)));
    }

    static protected $_env;
    public static function setEnvData($data) {
        static::$_env = $data;
    }

    public static function getEnv($name, $default = null) {
        if (!isset(static::$_env[$name])) {
            if (null === $default) {
                // когда еще не инициализирован Yii, эксепшен приходится бросать вручную
                throw new \yii\base\UnknownPropertyException("Environment variable $name is not set");
            } else {
                return $default;
            }
        }
        return static::$_env[$name];
    }

    public static function getNormalizedPathifo() {
        if (!isset($_SERVER['REQUEST_URI'])) {
            throw new \Exception("Unable to determine URL (are we under web server?).");
        }
        $pathInfo = $_SERVER['REQUEST_URI'];
        if (($pos = strpos($pathInfo, '?')) !== false) {
            $pathInfo = substr($pathInfo, 0, $pos);
        }

        return preg_replace('#/{2,}#', '/', '/' . $pathInfo);
    }

}

function D()
{
    if (Asm::isDebug()) {
        $backtrace = debug_backtrace();
        $caller = $backtrace[0];
        print_r(func_get_args());
        echo "\n<br>\nAsmDebug in {$caller['file']} line {$caller['line']}";
        die();
    } else {
        die('by D');
    }
}
