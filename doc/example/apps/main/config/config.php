<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 16.03.17
 * Time: 10:09
 */

$config = [
    'id' => 'main',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'main\controllers',
    'aliases' => require Yii::getAlias('@common/config/_aliases-yii-app.php'),
    'components' => [
        'db' => require Yii::getAlias('@common/config/_db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ]
];

$common_components = require Yii::getAlias('@common/config/_components-common.php');

return \yii\helpers\ArrayHelper::merge($common_components, $config);