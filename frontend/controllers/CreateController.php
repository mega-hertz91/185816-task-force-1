<?php


namespace frontend\controllers;


use frontend\forms\CreateTaskForm;
use frontend\helpers\Date;
use frontend\models\Task;
use frontend\models\User;
use Yii;

class CreateController extends BaseController
{
    public function actionIndex()
    {
        $model = new CreateTaskForm();
        $task = new Task();
        $request = Yii::$app->request->post();
        $errors = '';

        $id = Yii::$app->user->id;
        $user = User::findOne($id);

        if ($user->role->id === User::EXECUTOR) {
            Yii::$app->session->setFlash('error', 'У вас недостаточно прав на публикацию задания');
            return $this->redirect('/tasks/');
        }

        if ($model->load($request)) {
           if ($model->validate()) {
               $task->attributes = $request['CreateTaskForm'];
               $task->city_id = $model::DEFAULT_CITY;
               $task->status_id = $model::DEFAULT_STATUS;
               $task->user_id = $user->id;
               $task->deadline = Date::getDateBase($task->deadline);
               $task->save();

               $this->redirect('/tasks/');

           } else {
               $errors = $model->errors;
           }
        }


        return $this->render('index', [
            'model' => $model,
            'errors' => $errors,
            'task' => $task
        ]);
    }
}
