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
            'access' =>  [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect('/');
                }
            ]
        ];
    }
}
