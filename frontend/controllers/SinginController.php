<?php


namespace frontend\controllers;


use frontend\forms\SinginForm;
use frontend\forms\SingupForm;
use Yii;

class SinginController extends BaseController
{
    public $model;

    public function beforeAction($action)
    {
        if(Yii::$app->user->isGuest) {
            return 'you guest';
        } else {
            return Yii::$app->response->redirect('/tasks/');
        }
    }

    public function actionIndex()
    {
        $this->layout = 'landing';
        $model = new SinginForm();
        $request = Yii::$app->request->post();
        $session = Yii::$app->session;
        $this->model = new SingupForm();

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
