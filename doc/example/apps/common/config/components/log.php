<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 10.05.17
 * Time: 14:53
 */

return [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'flushInterval' => YII_DEBUG ? 1 : 100,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning', 'info'],
                'categories' => ['app/*'],
                'logFile' => '@log/php.log',
                'logVars' => [],
                'exportInterval' => YII_DEBUG ? 1 : 1000
            ],
        ],
];