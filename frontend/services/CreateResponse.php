<?php


namespace frontend\services;


use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;

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


    public function refuseResponse(User $currentUser): void
    {
        if ($this->response->task->user_id !== $currentUser->id) {
            throw new \Exception('Вы не владелец текущего задания');
        }

        if ($currentUser->isExecutor()) {
            throw new \Exception('У вас не достаточно прав');
        }

        $this->response->status = $this->response::STATUS_DISABLED;

        if (!$this->response->save()) {
            throw new \Exception('Отклик не был сохранен');
        }
    }

    /**
     * @param Task $task
     * @param User $currentUser
     * @throws \Exception
     */

    public function addNewResponse(Task $task, User $currentUser): void
    {
        $this->response->task_id = $task->id;
        $this->response->user_id = $currentUser->id;

        if($this->response::findOne(['user_id' => $currentUser->id]) !== null) {
            throw new \Exception('Вы уже отликались на текущее задание');
        }

       if (!$this->response->save()) {
            throw new \Exception('Отклик не был сохранен');
        }
    }
}
