<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 16.03.17
 * Time: 10:12
 */

// Resolve root dynamically, because console tasks such as
//    ./yii migrate
// can be run while deploying, but before project is moved to real project root
Yii::setAlias('@root', dirname(dirname(dirname(__DIR__))));

// core
Yii::setAlias('@var', '@root/var');
Yii::setAlias('@tmp', '@root/tmp');
Yii::setAlias('@apps', '@root/apps');

// yii apps
Yii::setAlias('@common', '@apps/common');
Yii::setAlias('@console', '@apps/console');
