<?php


namespace frontend\controllers;


use frontend\forms\CreateTaskForm;
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

        $id = Yii::$app->user->id;
        $user = User::findOne($id);

        if($user->role->id === User::EXECUTOR) {
            Yii::$app->session->setFlash('error', 'У вас недостаточно прав на публикацию задания');
            return $this->redirect('/tasks/');
        }

        if($model->load($request)) {
            var_dump($request);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
