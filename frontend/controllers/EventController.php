<?php


namespace frontend\controllers;


use common\models\Notice;
use Yii;
use yii\web\Controller;

class EventController extends Controller
{
    public function actionIndex()
    {
        return json_encode(Notice::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all(), JSON_UNESCAPED_UNICODE);
    }
}
