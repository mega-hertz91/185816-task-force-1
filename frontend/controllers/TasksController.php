<?php

namespace frontend\controllers;

use frontend\forms\TasksForm;
use frontend\models\Category;
use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;
use Yii;
use frontend\providers\TasksProvider;
use yii\debug\panels\EventPanel;
use yii\web\NotFoundHttpException;

class TasksController extends BaseController
{
    public function actionIndex()
    {
        $form = new TasksForm();
        $request = Yii::$app->request;
        $param = [];

        if ($form->load($request->post())) {
            $form->attributes = $request->post()['TasksForm'];
            $param = $form->attributes;
        }

        if ($request->get('category_id') && Category::find()->where(['id' => $request->get('category_id')])) {
            $param = ['categories' => $request->get('category_id')];
        }

        return $this->render('index', [
            'tasks' => TasksProvider::getContent($param),
            'model' => $form,
            'categories' => Category::find()->select(['category_name'])->indexBy('id')->column()
        ]);
    }

    public function actionView($id)
    {
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        /**
         * @var Task $task
         */
        $task = Task::find()->where(['id' => $id])->with(['user', 'responses','responses.user', 'category'])->one();

        if($task === null) {
            throw new NotFoundHttpException('Такого задания не существует');
        }

        if ($task->isDefaultStatus()) {
            return $this->render('task', [
                'task' => $task,
            ]);
        } else if ($task->isUserOwner($user) || $task->isUserExecutor($user)) {
            return $this->render('task', [
                'task' => $task,
            ]);
        } else {
            throw new NotFoundHttpException('У вас нет прав просматривать текущее задание');
        }

    }
}
