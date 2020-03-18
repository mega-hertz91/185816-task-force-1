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
    public function actionWork($id)
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);
        $executor = User::findOne(['id' => Yii::$app->request->get()['executor']]);
        $task = Task::findOne(['id' => $id]);

        if ($user->isCustomer() && $executor->isExecutor()) {
            if ($task->changeStatusWork($executor)) {
                Yii::$app->session->setFlash('success', "Пользователь $executor->full_name назначен на задание $task->title");
                return $this->redirect('/tasks/');
            } else {
                Yii::$app->session->setFlash('error', 'Пользователь не был назначен, ошибка записи');
                return $this->redirect('/tasks/view/' . $task->id);
            }
        }

        Yii::$app->session->setFlash('error', 'Один из пользователей не является заказчиком или исполнителем');
        return $this->redirect('/tasks/view/' . $task->id);
    }


    /***
     * @param integer $id
     * @return \yii\web\Response
     */
    public function actionRefuse($id)
    {
        $response = Response::findOne(['id' => $id]);

        if ($response !== null) {
            if($response->refuseResponse()) {
                Yii::$app->session->setFlash('success', 'В отклике отказано');
                return $this->redirect('/tasks/view/' . $response->task_id);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при отказе, обратитесь к администратору');
                return $this->redirect('/tasks/view/' . $response->task_id);
            }
        }

        Yii::$app->session->setFlash('error', 'Отклика с таким id не найдено');
        return $this->redirect('/tasks/view/' . $response->task_id);
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
            if ($task->changeStatusFailed($comment, $executor)) {
                Yii::$app->session->setFlash('error', 'Вы отказались от задания, это сильно повлияет на общий рейтинг');
                return $this->redirect('/tasks/');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка отказа, обратитесь к администратору сайта');
                return $this->redirect('/tasks/view/' . $task->id);
            }
        }

        Yii::$app->session->setFlash('error', 'Такого задания не существует');
        return $this->redirect('/tasks/');
    }
}
