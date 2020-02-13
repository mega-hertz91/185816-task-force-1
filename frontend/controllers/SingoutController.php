<?php


namespace frontend\controllers;


use frontend\helpers\AccessSettings;
use Yii;
use yii\web\Controller;

class SingoutController extends Controller
{
    public function behaviors()
    {
        return AccessSettings::Guest();
    }

    public function actionIndex()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
