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

/**
 * Debug function. Prints data and dies.
 *
 * To use globally, define global function:
 *
 * ```
 * function D($var = null, $vardump = null) { 'hack: autoload Asm.php --> ' . \cronfy\asm\Asm::$debug; call_user_func_array('\cronfy\asm\D', [$var, $vardump, 1]); }
 * ```
 *
 * Usage example: `D()` or `D($some_var)`
 *
 * @param mixed $var data to dump
 * @param bool $vardump whether to use var_dump, if false then print_r will be used. Default false.
 * @param int $backtrace_index tuning when called indirectly (e. g. via other debug function)
 */
function D($var, $vardump = false, $backtrace_index = 0)
{
    if (Asm::isDebug()) {
        $backtrace = debug_backtrace();
        $caller = $backtrace[$backtrace_index];
        if ($vardump) {
            var_dump($var);
        } else {
            print_r($var);
        }
        echo "\n<br>\nAsmDebug in {$caller['file']} line {$caller['line']}";
        die();
    } else {
        die('by D');
    }
}

function E($var, $vardump = false, $backtrace_index = 0)
{
    if (Asm::isDebug()) {
        $backtrace = debug_backtrace();
        $caller = $backtrace[$backtrace_index];
        if ($vardump) {
            var_dump($var);
        } else {
            print_r($var);
        }
        echo " <small>AsmEcho in {$caller['file']} line {$caller['line']}</small><br>\n";
    } else {
        // do not echo
    }
}
