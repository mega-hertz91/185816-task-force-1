<?php

namespace frontend\controllers;

use frontend\models\Task;
use Yii;

class TasksController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $tasks = Task::find()->where(['status_id' => 5])->all();
        $title = 'Tasks';

        foreach ($tasks as $task) {
            $task->created_at = Yii::$app->formatter->asDate($task->created_at);
        }

       return $this->render('index', [
            'title' => $title,
            'tasks' => $tasks
        ]);
    }
}
