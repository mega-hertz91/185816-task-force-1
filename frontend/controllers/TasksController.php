<?php

namespace frontend\controllers;

use frontend\forms\TasksForm;
use frontend\models\Category;
use frontend\models\Task;
use Yii;
use yii\data\ActiveDataProvider;

class TasksController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $tasks = Task::find()->where(['status_id' => 5])->all();
        $title = 'Tasks';
        $request = Yii::$app->request;
        $result = 'request not found';

        foreach ($tasks as $task) {
            $task->created_at = Yii::$app->formatter->asDate($task->created_at);
        }

        if ($request->isPost) {
            $cat = $request->post()['TasksForm']['categories'];

            $result = Category::find()->where([
                //'tag' => $cat,
                'tag' => $cat
            ])->all();
        }

        return $this->render('index', [
            'title' => $title,
            'tasks' => $tasks,
            'model' => new TasksForm(),
            'result' => $result
        ]);
    }
}
