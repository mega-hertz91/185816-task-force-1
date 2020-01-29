<?php


namespace frontend\controllers;

use frontend\forms\TasksFilterForm;
use frontend\models\Category;
use yii\web\Controller;
use Yii;

class FormController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $result = 'bad request';

        if($request->isPost) {
            $result = $request->post();
        }

        return $this->render('index',
            [
                'model' => new TasksFilterForm(),
                'result' => $result
            ]);
    }
}
