<?php

namespace frontend\controllers;

use frontend\forms\TasksForm;
use frontend\models\Category;
use frontend\models\Task;
use frontend\models\User;
use Yii;
use frontend\providers\TasksProvider;
use yii\web\NotFoundHttpException;

class TasksController extends BaseController
{
    public function actionIndex()
    {
        $form = new TasksForm();
        $request = Yii::$app->request->post();

        if ($form->load($request)) {
            $form->attributes = $request['TasksForm'];
        }

        return $this->render('index', [
            'tasks' => TasksProvider::getContent($form->attributes),
            'model' => $form,
            'categories' => Category::find()->select(['category_name'])->indexBy('id')->column()
        ]);
    }

    public function actionView($id)
    {
        $task = Task::findOne($id);
        $user = User::findOne(['id' => Yii::$app->user->id]);

        if($task === null) {
            throw new NotFoundHttpException('Такого задания не существует');
        } elseif ($task->status_id === Task::DEFAULT_STATUS) {
            return $this->render('task', [
                'task' => $task,
            ]);
        } elseif ($task->executor_id === $user->role->id) {
            return $this->render('task', [
                'task' => $task,
            ]);
        }

        return $this->redirect('/tasks/');
    }
}
