<?php


namespace src\status;

use common\models\Task;
use common\models\User;
use src\exceptions\StatusException;

class WorkAction extends AvailableActions
{
    protected $roles = [self::ROLE_ADMIN, self::ROLE_CUSTOMER];
    protected $nextStatus = self::STATUS_WORK;
    protected $accessStatuses = [self::STATUS_PUBLIC];
    protected $executor;

    public function __construct(Task $task, User $currentUser, User $executor)
    {
        $this->executor = $executor;
        parent::__construct($task, $currentUser);
    }

    public function checkPermission(): void
    {
        if (!$this->task->isUserOwner($this->currentUser)) {
            throw new StatusException('Доступ запрещен, обратитесь к администратору');
        }
    }

    public function apply(): void
    {
        $this->task->executor_id = $this->executor->id;
        parent::apply();
    }
}
