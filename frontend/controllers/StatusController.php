<?php


namespace frontend\controllers;


use frontend\models\Comment;
use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;
use Yii;

class StatusController extends BaseController
{
    /**
     * @param integer $id
     * @return \yii\web\Response
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

            Yii::$app->session->setFlash('success', "Пользователь $executor->full_name назначен на задание $task->title");

            return $this->redirect('/tasks/');
        }

        Yii::$app->session->setFlash('error', 'Один из пользователей не является заказчиком или исполнителем');

        return $this->redirect('/tasks/');
    }


    /***
     * @param integer $id
     * @return \yii\web\Response
     */
    public function actionRefuse($id)
    {
        $response = Response::findOne(['id' => $id]);
        if ($response !== null) {
            $response = Response::findOne(['id' => $id]);

            $response->status = Response::STATUS_DISABLED;
            $response->save();

            Yii::$app->session->setFlash('success', 'В отклике отказано');

            return $this->redirect('/tasks/');
        }

        Yii::$app->session->setFlash('error', 'Отклика с таким id не найдено');

        return $this->redirect('/tasks/');
    }


    /***
     * @param integer $id
     * @return \yii\web\Response
     */
    public function actionFailed($id)
    {
        $task = Task::findOne(['id' => $id]);
        $executor = User::findOne(['id' => $task->executor_id]);
        $comment = new Comment();

        if ($task !== null) {
            $comment->task_id = $task->id;
            $comment->user_id = $task->user_id;
            $comment->executor_id = $executor->id;
            $comment->description = 'Задание провалено';
            $comment->rating = 0;
            $comment->save();

            $executor->rating = $comment->getRating($executor->id);
            var_dump($executor->save());
            $task->status_id = Task::STATUS_FAILED;
            $task->save();

            Yii::$app->session->setFlash('error', 'Вам выставленна оценка 0 за текущее задание');
            return $this->redirect('/tasks/');
        }

        Yii::$app->session->setFlash('error', 'Такого задания не существует');
        return $this->redirect('/tasks/');
    }
}
