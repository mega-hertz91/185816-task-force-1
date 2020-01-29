<?php

namespace frontend\controllers;

use frontend\forms\TasksFilterForm;
use frontend\models\Category;
use frontend\models\Task;
use yii\web\Controller;
use Yii;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->where(['status_id' => 5])->all();
        $title = 'Tasks';
        $form = new TasksFilterForm();
        $request = Yii::$app->request->post();
        $result = '';

        if($form->load($request['TasksFilterForm'])) {
            $form->attributes = $request['TasksFilterForm'];
        }

        return $this->render('index', [
            'title' => $title,
            'tasks' => $tasks,
            'model' => $form,
            'categories' => Category::find()->select(['category_name'])->indexBy('id')->column(),
            'result' => $form->attributes
        ]);
    }
}
