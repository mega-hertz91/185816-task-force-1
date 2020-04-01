<?php


namespace frontend\controllers;


use frontend\forms\NewResponseForm;
use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;
use yii\web\Controller;
use Yii;

class ResponseController extends Controller
{
    public function actionNew($task_id)
    {
        $task = Task::findOne($task_id);
        $response_model = new Response();
        $response_form = new NewResponseForm();
        $request = Yii::$app->request->post();
        $user = User::findOne(['id' => $task->user_id]);

        if ($task !== null && $response_form->load($request)) {
            $response_model->setAttributes($request['NewResponseForm']);

            if (!$user->isExecutor()) {
                Yii::$app->session->setFlash('error', 'Вам запрещено добавлять отклики');
                return  $this->redirect("/tasks/view/$task_id");
            }

            if ($response_model->addNewResponse($task, Yii::$app->user->id)) {
                Yii::$app->session->setFlash('success', 'Отклик успешно добавлен');
                return  $this->redirect("/tasks/view/$task_id");
            } else {
                Yii::$app->session->setFlash('error', 'Отклик не был добавлен');
                return  $this->redirect("/tasks/view/$task_id");
            }
        } else {
            Yii::$app->session->setFlash('error', 'Такого задания не существует');

            return $this->redirect('/tasks/');
        }
    }
}
