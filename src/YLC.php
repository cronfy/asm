<?php

namespace cronfy\asm;

use cronfy\ylc\yii\web\Response;
use cronfy\ylc\yii\web\View;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\UnknownMethodException;
use yii\helpers\Url;
use yii\web\UrlManager;

class YLC {

    const RESULT_YII_REDIRECT = 'yii-redirect';
    const RESULT_YII_RESPONSE = 'yii-response';
    const RESULT_YII_NOT_ROUTED = 'yii-not-routed';
    const RESULT_YII_NOT_FOUND = 'yii-not-found';
    const RESULT_GO_TO_LEGACY = 'go-to-legacy';

    /**
     * Runs yii application, but prevents it from sending response (cookies, headers, content).
     *
     * Sets `Yii::$app->params['resultType']`, describing result of execution: got response,
     * not routed, not found etc.
     */
    public static function runLegacy() {
        try {
            Yii::$app->on(\yii\base\Application::EVENT_AFTER_REQUEST, function ($event) {
                if (in_array(Yii::$app->response->statusCode, [301, 302])) {
                    Yii::$app->params['resultType'] = static::RESULT_YII_REDIRECT;
                } else {
                    Yii::$app->params['resultType'] = static::RESULT_YII_RESPONSE;
                }

                $e = new \cronfy\ylc\GoToLegacyException();
                throw $e;
            });
            Yii::$app->run();
            throw new \Exception("Legacy app myst end with exception.");
        } catch (\yii\web\NotFoundHttpException $e) {
            if ($orig_e = $e->getPrevious() and get_class($orig_e) == \yii\base\InvalidRouteException::class) {
                Yii::$app->params['resultType'] = static::RESULT_YII_NOT_ROUTED;
            } else {
                // Normal NotFound response.
                Yii::$app->params['resultType'] = static::RESULT_YII_NOT_FOUND;
            }
        } catch (\cronfy\ylc\GoToLegacyException $e) {
            if (!isset(Yii::$app->params['resultType'])) {
                Yii::$app->params['resultType'] = static::RESULT_GO_TO_LEGACY;
            }
        }
    }

    /**
     * @param UrlManager $urlManager the UrlManager to create URL
     * @param string|array $route use a string to represent a route (e.g. `index`, `site/index`),
     * or an array to represent a route with query parameters (e.g. `['site/index', 'param1' => 'value1']`).
     * @param boolean|string $scheme the URI scheme to use in the generated URL:
     *
     * - `false` (default): generating a relative URL.
     * - `true`: returning an absolute base URL whose scheme is the same as that in [[\yii\web\UrlManager::hostInfo]].
     * - string: generating an absolute URL with the specified scheme (either `http` or `https`).
     *
     * @return string the generated URL
     * @return string
     */
    public static function urlToRoute($urlManager, $route, $scheme = null) {
        $route = (array) $route;

        if (strpos('/', $route[0]) !== 0) {
            // route must be absolute to avoid 'No active controller'
            // exception from Url::normalizeRoute()
            $route[0] = '/' . $route[0];
        }

        $prevManager = Url::$urlManager;
        Url::$urlManager = $urlManager;
        $url = Url::toRoute($route, $scheme);
        Url::$urlManager = $prevManager;

        return $url;
    }

    /**
     * Can be used to manually send cookies.
     *
     * When you use Html::csrfMetaTags() in legacy template, Yii will generate CSRF token,
     * but will not send it, as Yii::$app->response->send() is not called.

     * You can call this method manually to send CSRF token and other cookies before
     * sending content from legacy.
     *
     * @throws InvalidConfigException
     */
    public static function sendCookies() {
        $response = Yii::$app->response;
        try {
            $response->sendCookies();
        } catch (UnknownMethodException $e) {
            throw new InvalidConfigException("Response::sendCookies() must be public, use " . Response::class . " instead of " . get_class($response));
        }
    }

}
