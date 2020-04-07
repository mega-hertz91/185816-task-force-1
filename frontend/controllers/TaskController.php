<?php


namespace frontend\controllers;


use frontend\forms\CompleteTaskForm;
use frontend\models\Comment;
use frontend\models\Task;
use frontend\services\CreateComment;
use frontend\src\exceptions\StatusException;
use frontend\src\status\CancelAction;
use frontend\models\User;
use frontend\src\status\FailedAction;
use frontend\src\status\WorkAction;
use frontend\src\status\CompleteAction;
use Yii;

class TaskController extends BaseController
{
    protected $task;
    protected $target_user;

    public function __construct($id, $module, $config = [])
    {

        $this->task = Task::findOne(['id' => Yii::$app->request->get('id')]);
        $this->target_user = User::findOne(['id' => Yii::$app->user->id]);

        if ($this->task === null) {
            Yii::$app->session->setFlash('error', 'Задание не найдено');
            $this->redirect('/tasks/');
        }

        parent::__construct($id, $module, $config);
    }

    /***
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */

    public function beforeAction($action)
    {
        if ($this->task === null) {
            Yii::$app->session->setFlash('error', 'Задание не найдено');
            $this->redirect('/tasks/');

        } else {
            return parent::beforeAction($action);
        }

        return false; // TODO: Change the autogenerated stub
    }

    public function actionCancel()
    {
        $cancel = new CancelAction($this->task, $this->target_user);

        try {
            $cancel->apply();
            Yii::$app->session->setFlash('success', 'Задание успешно отменено');
            $this->redirect('/tasks/');
        } catch (StatusException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect('/tasks/');
        }
    }

    public function actionWork($executor)
    {
        $executor = User::findOne(['id' => $executor]);

        $work = new WorkAction($this->task, $this->target_user, $executor);

        try {
            $work->apply();
            Yii::$app->session->setFlash('success', 'На задание "' . $this->task->title . '" назначен исполнитель: ' . $executor->full_name);
            $this->redirect('/tasks/');
        } catch (StatusException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect('/tasks/');
        }
    }

    public function actionRefuse()
    {
        $refuse = new FailedAction($this->task, $this->target_user);
        $comment = new CreateComment(new Comment());

        try {
            $comment->addNewFailedComment($this->task);
            $this->target_user->setRating($comment->getRating($this->target_user));
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect('/tasks/');
        }

        try {
            $refuse->apply();
            Yii::$app->session->setFlash('success', 'Вы отказались от задания, это повлияет на общий рейтинг');
            $this->redirect('/tasks/');
        } catch (StatusException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect('/tasks/');
        }
    }

    public function actionComplete()
    {
        $form = new CompleteTaskForm();
        $request = Yii::$app->request->post();
        $complete = new CompleteAction($this->task, $this->target_user);
        $executor = User::findOne(['id' => $this->task->executor_id]);
        $comment = new CreateComment(new Comment());

        if ($form->load($request)) {
            $completed = intval($request['complete']);
            if ($completed === 1) {
                $complete = new CompleteAction($this->task, $this->target_user);
                try {
                    $comment->comment->setAttributes($request['CompleteTaskForm']);
                    $comment->addNewCompleteComment($this->task);
                    $executor->setRating($comment->getRating($executor));
                    $complete->apply();

                    Yii::$app->session->setFlash('success', 'Задание успешно выполненно');
                    $this->redirect('/tasks/');
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                    $this->redirect('/tasks/');
                }
            } else {
                $complete = new FailedAction($this->task, $this->target_user);
                $complete->finishedFailed();
                try {
                    $comment->addNewFailedComment($this->task);
                    $executor->setRating($comment->getRating($executor));
                    $complete->apply();

                    Yii::$app->session->setFlash('success', 'Задание переведено в статус провалено');
                    $this->redirect('/tasks/');
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                    $this->redirect('/tasks/');
                }
            }
        } else {
            $this->redirect('/tasks/');
        }
    }
}
