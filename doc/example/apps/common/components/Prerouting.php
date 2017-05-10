<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 09.05.17
 * Time: 17:30
 */

namespace common\components;

use cronfy\asm\Asm;
use Yii;
use cronfy\ylc\YLC;
use yii\web\Application;

class Prerouting
{
    public static function route() {
        if (php_sapi_name() == 'cli') {
            return;
        }

        $pathInfo = Asm::getNormalizedPathifo();

        switch (true) {
//            case $pathInfo == '... something that should be processed by apps/main ...': 
//                $config = require(Yii::getAlias('@main/config/config.php'));
//                $application = new Application($config);
//                $application->run();
//                exit();
//                break;
            default: // run legacy
                $config = require(Yii::getAlias('@legacy/config/config.php'));
                new Application($config);

                YLC::tryYii(); 
                break;
        }
    }
}
