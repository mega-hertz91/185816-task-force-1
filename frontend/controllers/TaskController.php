<?php

namespace frontend\controllers;

use frontend\extensions\models\NoticeExtension;
use frontend\forms\CompleteTaskForm;
use frontend\forms\CreateTaskForm;
use common\models\Comment;
use common\models\Task;
use common\models\User;
use frontend\services\LocationService;
use src\exceptions\StatusException;
use src\status\CancelAction;
use src\status\CompleteAction;
use src\status\FailedAction;
use src\status\RefuseAction;
use src\status\WorkAction;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;


class TaskController extends BaseController
{
    /**
     * @var Task $task
     */
    protected $task;

    /**
     * @var User $currentUser
     */
    protected $currentUser;

    /**
     * @param Action $action
     * @return bool
     * @throws NotFoundHttpException
     */

    public function beforeAction($action): bool
    {
        if (Yii::$app->request->get('id') && Yii::$app->request->get('id') !== null) {
            $this->task = Task::findOrFail(['id' => Yii::$app->request->get('id')]);
        }

        $this->currentUser = Yii::$app->user->identity;

        return parent::beforeAction($action);
    }

    public function actionCreate()
    {
        $model = new CreateTaskForm();
        $request = Yii::$app->request->post();
        $location = new LocationService();

        if ($model->load($request) && $model->validate()) {
            try {
                Task::createTask($model, $this->currentUser, $location);
            } catch (InvalidConfigException $e) {
                Yii::$app->session->setFlash('error', 'Не верный формат даты');
                return $this->redirect(Url::to(['tasks/index']));
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(Url::to(['tasks/index']));
            }

            Yii::$app->session->setFlash('success', 'Ваше задание успешно опубликовано');
            $this->redirect(Url::to(['tasks/index']));
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionCancel()
    {
        try {
            $cancelAction = new CancelAction($this->task, $this->currentUser);
            $cancelAction->apply();
            Yii::$app->session->setFlash('success', 'Задание успешно отменено');
            NoticeExtension::create(Yii::$app->user->id, NoticeExtension::CATEGORY_ACTION, $this->task->id);
            return $this->redirect(Url::to(['tasks/index']));
        } catch (StatusException | \Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Url::to(['tasks/index']));
        }
    }

    public function actionComplete()
    {
        $form = new CompleteTaskForm();
        $request = Yii::$app->request->post();
        $executor = User::findOne(['id' => $this->task->executor_id]);

        if ($form->load($request) && $form->validate()) {
            $completedField = intval($request['complete']);
            $completeAction = new CompleteAction($this->task, $this->currentUser, $completedField);

            if ($completeAction->isComplete()) {
                try {
                    Comment::createCompleteComment($this->task, $form);
                    $executor->setRating(Comment::getRating($executor->id));
                    $completeAction->apply();

                    Yii::$app->session->setFlash('success', 'Задание успешно выполненно');
                    $this->redirect(Url::to(['tasks/index']));
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                    $this->redirect(Url::to(['tasks/index']));
                }
            } else {
                $completeAction = new FailedAction($this->task, $this->currentUser);
                $completeAction->finishedFailed();
                try {
                    Comment::createCompleteComment($this->task, $form);
                    $executor->setRating(Comment::getRating($executor->id));
                    $completeAction->apply();

                    Yii::$app->session->setFlash('success', 'Задание переведено в статус провалено');
                    $this->redirect(Url::to(['tasks/index']));
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                    $this->redirect(Url::to(['tasks/index']));
                }
            }
        } else {
            $this->redirect(Url::to(['tasks/index']));
        }
    }

    public function actionRefuse()
    {
        $refuseAction = new RefuseAction($this->task, $this->currentUser);

        try {
            Comment::createFailedComment($this->task);
            $this->currentUser->setRating(Comment::getRating($this->currentUser->id));
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect(Url::to(['tasks/index']));
        }

        try {
            $refuseAction->apply();
            Yii::$app->session->setFlash('success', 'Вы отказались от задания, это повлияет на общий рейтинг');
            $this->redirect(Url::to(['tasks/index']));
        } catch (StatusException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect(Url::to(['tasks/index']));
        }
    }

    public function actionWork($executor)
    {
        $executor = User::findOne(['id' => $executor]);

        try {
            $workAction = new WorkAction($this->task, $this->currentUser, $executor);
            $workAction->apply();
            NoticeExtension::create($executor->id, NoticeExtension::CATEGORY_ACTION, $this->task->id);
            Yii::$app->session->setFlash('success',
                'На задание "' . $this->task->title . '" назначен исполнитель: ' . $executor->full_name);
            $this->redirect(Url::to(['tasks/index']));
        } catch (StatusException | \Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect(Url::to(['tasks/index']));
        }
    }
}
