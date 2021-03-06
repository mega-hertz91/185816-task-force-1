<?php


namespace frontend\controllers;

use frontend\extensions\models\NoticeExtension;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class BaseController extends Controller
{
    public $notices;

    public function behaviors()
    {
        return [
            'access' => [
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

    public function beforeAction($action)
    {
        NoticeExtension::CATEGORY_RESPONSE;
        $this->notices = NoticeExtension::find()
            ->where(
                [
                    'user_id' => Yii::$app->user->id,
                    'visible' => true
                ]
            )
            ->all();
        return parent::beforeAction($action);
    }
}
