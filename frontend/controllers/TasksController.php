<?php

namespace frontend\controllers;

use frontend\forms\TasksForm;
use frontend\models\Category;
use frontend\models\Task;
use yii\web\Controller;
use Yii;
use frontend\providers\TasksProvider;
use yii\web\NotFoundHttpException;
use frontend\helpers\AccessSettings;

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

        if($task === null) {
            throw new NotFoundHttpException('Такого задания не существует');
        }

        return $this->render('task', [
            'task' => $task,
        ]);
    }

    public function actionTest()
    {
        Yii::$app->on(Controller::EVENT_BEFORE_ACTION);
    }
}
