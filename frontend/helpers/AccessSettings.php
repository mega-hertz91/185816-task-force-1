<?php


namespace frontend\helpers;


use yii\web\Controller;
use Yii;

class AccessSettings
{
    public static function Guest()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    Yii::$app->response->redirect('/singin');
                }
            ]
        ];
    }

    public static function User()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    Yii::$app->response->redirect('tasks');
                }
            ]
        ];
    }
}
