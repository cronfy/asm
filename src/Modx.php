<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 14.03.17
 * Time: 16:04
 */

namespace cronfy\asm;

use Yii;

class Modx
{

    public static $events;

    public static function init() {
        // Modx has modx_sanitize_gpc() function which modifies cookies, which leads
        // to cookies can not be validated by yii\base\Security.
        // Let's load cookies BEFORE Modx touches them.
        Yii::$app->request->getCookies();
    }

    /**
     * @param $modx \DocumentParser
     */
    public static function event($modx) {
        $event = $modx->Event->name;
        if (isset(static::$events[$event])) {
            foreach (static::$events[$event] as $callback) {
                $callback($modx);
            }
        }
    }
}