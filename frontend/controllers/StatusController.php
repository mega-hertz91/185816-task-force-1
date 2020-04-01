<?php


namespace frontend\controllers;


use frontend\forms\CompleteTaskForm;
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

        if (!$task->isDefaultStatus()) {
            Yii::$app->session->setFlash('error', 'Статус задания не "новое"');
            return $this->redirect('/tasks/view/' . $task->id);
        }

        if ($user->isCustomer() && $executor->isExecutor()) {
            if ($task->changeStatusWork($executor)) {
                Yii::$app->session->setFlash(
                    'success',
                    "Пользователь $executor->full_name назначен на задание $task->title"
                );
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
            if ($response->refuseResponse()) {
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

        if (!$task->isWorkStatus()) {
            Yii::$app->session->setFlash('error', 'Статус задания не совпадает');
            return $this->redirect('/tasks/view/' . $task->id);
        }

        if ($task !== null) {
            if ($task->changeStatusFailed() && $executor->setRecountRating($comment) && $comment->addNewFailedComment(
                    $task
                )) {
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

    public function actionCancel($id)
    {
        $task = Task::findOne(['id' => $id]);
        $user = User::findOne(['id' => Yii::$app->user->id]);

        if (!$task->isDefaultStatus()) {
            Yii::$app->session->setFlash('error', 'Статус задания не "новое"');
            return $this->redirect('/tasks/view/' . $task->id);
        }

        if (!$user->isCustomer() && !$task->isUserOwner($user)) {
            Yii::$app->session->setFlash('error', 'Вы не являетесь владельцем задания');
            return $this->redirect('/tasks/');
        }

        if ($task !== null) {
            if ($task->changeStatusCanceled()) {
                Yii::$app->session->setFlash('success', 'Задание успешно отменено');
                return $this->redirect('/tasks/');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка отмены, обратитесь к администратору сайта');
                return $this->redirect('/tasks/view/' . $task->id);
            }
        }

        Yii::$app->session->setFlash('error', 'Такого задания не существует');
        return $this->redirect('/tasks/');
    }

    public function actionComplete($id)
    {
        $request = Yii::$app->request->post();
        $form_complete_model = new CompleteTaskForm();
        $comment = new Comment();
        $task = Task::findOne(['id' => $id]);
        $user = User::findOne(['id' => $task->executor_id]);

        if (!$task->isWorkStatus()) {
            Yii::$app->session->setFlash('error', 'Статус задания не совпадает');
            return $this->redirect('/tasks/view/' . $task->id);
        }

        if ($form_complete_model->load($request)) {
            $comment->setAttributes($request['CompleteTaskForm']);
            if ($form_complete_model->isCompleted()) {
                $comment->addNewCompleteComment($task);
                $task->changeStatusCompleted();
                $user->setRecountRating($comment);

                Yii::$app->session->setFlash('success', 'Задание успешно завершено');
                return $this->redirect('/tasks/');
            } else {
                $comment->addNewCompleteComment($task);
                $task->changeStatusFailed();
                $user->setRecountRating($comment);

                Yii::$app->session->setFlash('error', 'Заданию присвоен статус "провалено"');
                return $this->redirect('/tasks/');
            }
        }

        Yii::$app->session->setFlash('error', 'Такого задания не существует');
        return $this->redirect('/tasks/view/' . $task->id);
    }
}
