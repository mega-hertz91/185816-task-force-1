<?php

namespace frontend\controllers;

use frontend\forms\TasksForm;
use frontend\models\Category;
use frontend\models\Task;
use yii\web\Controller;
use Yii;
use frontend\providers\TasksProvider;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $form = new TasksForm();
        $request = Yii::$app->request->post();

        if($form->load($request)) {
            $form->attributes = $request['TasksForm'];
        }

        return $this->render('index', [
            'tasks' => TasksProvider::getContent($form->attributes)->getModels(),
            'model' => $form,
            'categories' => Category::find()->select(['category_name'])->indexBy('id')->column(),
            'result' => $form->attributes
        ]);
    }
}
