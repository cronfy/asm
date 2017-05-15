<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 16.03.17
 * Time: 10:09
 */

$config = [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'enableCoreCommands' => false,
    'controllerNamespace' => 'console\controllers',
    'aliases' => require Yii::getAlias('@common/config/_aliases-yii-app.php'),
    'components' => [
    ]
];

$common_components = require Yii::getAlias('@common/config/_components-common.php');

return \yii\helpers\ArrayHelper::merge($common_components, $config);
