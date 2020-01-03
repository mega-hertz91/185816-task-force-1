<?php

namespace frontend\controllers;

use app\models\User;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $users = User::find()->asArray()->all();

        return $this->render('index', [
            'users' => $users
        ]);
    }
}
