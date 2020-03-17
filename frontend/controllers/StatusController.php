<?php


namespace frontend\controllers;


use frontend\models\Task;
use yii\helpers\Url;
use yii\web\Controller;
use frontend\models\User;
use Yii;

class StatusController extends Controller
{
    /**
     * @param integer $id
     * @return string
     */
    public function actionNew($id)
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);
        $executor = User::findOne(['id' => Yii::$app->request->get()['executor']]);
        $task = Task::findOne(['id' => $id]);


        if ($user->role_id === User::CUSTOMER && $executor->role_id == User::EXECUTOR) {
            $task->status_id = Task::STATUS_WORK;
            $task->executor_id = $executor->id;
            $task->save();

            return $this->redirect('/tasks/');
        }

        Yii::$app->session->setFlash('error', 'У вас нет прав на процесс');

        return $this->redirect('/tasks/');
    }
}
