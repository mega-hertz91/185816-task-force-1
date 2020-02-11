<?php


namespace frontend\controllers;


use frontend\forms\SinginForm;
use frontend\helpers\AccessSettings;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class SinginController extends Controller
{
    public function behaviors()
    {
        return AccessSettings::User();
    }

    public function actionIndex()
    {
        $this->layout = 'landing';
        $model = new SinginForm();
        $request = Yii::$app->request->post();
        $session = Yii::$app->session;

        if ($model->load($request)) {
            if ($model->validate()) {
                $user = $model->getUser();
                \Yii::$app->user->login($user);
                $session->setFlash('reg', "Добро пожаловать $user->full_name");
                return $this->goHome();
            }
        }

        return $this->render('index',
            [
                'model' => $model
            ]);
    }
}
