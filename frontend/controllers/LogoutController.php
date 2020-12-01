<?php


namespace frontend\controllers;


use frontend\helpers\AccessSettings;
use Yii;
use yii\web\Controller;

class LogoutController extends BaseController
{

    public function actionIndex()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
