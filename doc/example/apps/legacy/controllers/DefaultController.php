<?php
/**
 * Created by PhpStorm.
 * User: cronfy
 * Date: 09.05.17
 * Time: 17:55
 */

namespace legacy\controllers;

use cronfy\ylc\GoToLegacyException;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionGoToLegacy() {
        throw new GoToLegacyException();
    }

}
