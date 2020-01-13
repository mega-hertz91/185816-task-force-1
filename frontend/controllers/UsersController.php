<?php


namespace frontend\controllers;


use frontend\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UsersController extends Controller
{
    public function actionIndex()
    {

        $users = User::find()->where(['role_id' => 3,])->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('index', [
            'title' => 'Исполнители',
            'users' => $users
        ]);
    }
}
