<?php


namespace frontend\controllers;


use yii\web\Controller;
use frontend\models\User;
use Yii;

class CreateController extends BaseController
{
    public function beforeAction($action)
    {
        $id = Yii::$app->user->id;
        $user = User::findOne($id);

        if($user->role->id === User::EXECUTOR) {
            Yii::$app->session->setFlash('error', 'У вас недостаточно прав на публикацию задания');
            return $this->redirect('/tasks/');
        } else {
            return 'success';
        }
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
