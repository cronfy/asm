<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 17.02.17
 * Time: 15:42
 */

use cronfy\asm\Asm;

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . Asm::getEnv('DB_HOST') . ';dbname=' . Asm::getEnv('DB_NAME'),
    'username' => Asm::getEnv('DB_USER'),
    'password' => Asm::getEnv('DB_PASS'),
    'charset' => 'utf8',
];
