<?php


namespace frontend\src\status;

use frontend\models\Task;
use frontend\models\User;
use frontend\src\status\AvailableActions;

class WorkAction extends AvailableActions
{
    protected $roles = [self::ROLE_ADMIN, self::ROLE_CUSTOMER];
    protected $next_status = self::STATUS_WORK;
    protected $access_statuses = [self::STATUS_PUBLIC];
    protected $executor;

    public function __construct(Task $task, User $target_user, User $executor)
    {
        $this->executor = $executor;
        parent::__construct($task, $target_user);
    }

    public function apply(): void
    {
        $this->setNextStatus();
        $this->task->executor_id = $this->executor->id;
        $this->task->save();
    }
}
