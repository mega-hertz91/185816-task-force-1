<?php


namespace frontend\services;


use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;
use yii\db\Exception;

class CreateResponse
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response
     */

    public function getObject()
    {
        return $this->response;
    }


    public function refuseResponse(User $target_user): void
    {
        if ($this->response->task->user_id !== $target_user->id) {
            throw new \Exception('Вы не владелец текущего задания');
        }

        if ($target_user->isExecutor()) {
            throw new \Exception('У вас не достаточно прав');
        }

        $this->response->status = $this->response::STATUS_DISABLED;

        if (!$this->response->save()) {
            throw new \Exception('Отклик не был сохранен');
        }
    }

    /**
     * @param Task $task
     * @param User $target_user
     * @throws \Exception
     */

    public function addNewResponse(Task $task, User $target_user): void
    {
        $this->response->task_id = $task->id;
        $this->response->user_id = $target_user->id;

        if($this->response::findOne(['user_id' => $target_user->id]) !== null) {
            throw new \Exception('Вы уже отликались на текущее задание');
        }

       if (!$this->response->save()) {
            throw new \Exception('Отклик не был сохранен');
        }
    }
}
