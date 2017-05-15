<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 16.03.17
 * Time: 10:09
 */

$config = [
    'id' => 'legacy',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'legacy\controllers',
    'aliases' => require Yii::getAlias('@common/config/_aliases-yii-app.php'),
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // urls that should be catched by lecacy yii2 app
                // (better to avoid it!)
                // 'site/action' => 'site/action',

                // catch all other requests
                '<url:.*>' => 'default/go-to-legacy'
            ],
        ],

    ]
];

$common_components = require Yii::getAlias('@common/config/_components-common.php');

return \yii\helpers\ArrayHelper::merge($common_components, $config);
