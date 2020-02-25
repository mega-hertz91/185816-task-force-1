<?php


namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'guest' =>  [
                'class' => AccessControl::className(),
                //'only' => ['index', 'view'],
                'rules' => [
                    [
                        'controllers' => ['Tasks', 'Users'],
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect('/');
                }
            ],
            'user' => [
                'class' => AccessControl::className(),
                'only' => ['site', 'singup', 'singin'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect('tasks');
                }
            ]
        ];
    }
}
