<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 11.03.17
 * Time: 14:08
 */

use Yii;

require_once(__DIR__ . "/../asm-init.php");

$application = new \yii\console\Application(require(Yii::getAlias('@console/config/config.php')));

print_r(Yii::$app->db->schema->tableNames);