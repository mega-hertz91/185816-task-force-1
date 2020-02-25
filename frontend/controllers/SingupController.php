<?php


namespace frontend\controllers;


use frontend\forms\SingupForm;
use frontend\helpers\AccessSettings;
use frontend\models\City;
use frontend\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class SingupController extends BaseController
{
    public $model;

    public function actionIndex ()
    {
        $this->layout = 'landing';
        $model = new SingupForm();
        $this->model = new SingupForm();
        $request = Yii::$app->request->post();
        $session = Yii::$app->session;
        $user = new User;

        if ($model->load($request)) {
            if ($model->validate()) {
                $user->attributes = $model->attributes;
                $user->setHash();
                $user->save();
                $session->setFlash('reg','Вы успешно зарегистрировались');
                return $this->redirect('/singin');
            }
        }

        return $this->render('index',
            [
                'model' => $model,
                'cities' => City::find()->select(['name'])->indexBy('id')->column(),
            ]);
    }
}
