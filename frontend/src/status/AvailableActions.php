<?php

namespace frontend\src\status;

use frontend\models\Task;
use frontend\models\User;
use frontend\src\exceptions\StatusException;

abstract class AvailableActions
{
    const STATUS_WORK = 1;
    const STATUS_COMPLETE = 2;
    const STATUS_FAILED = 3;
    const STATUS_CANCEL = 4;
    const STATUS_PUBLIC = 5;
    const ROLE_ADMIN = 1;
    const ROLE_CUSTOMER = 2;
    const ROLE_EXECUTOR = 3;

    public $task;
    public $target_user;
    protected $next_status = 0;
    protected $access_statuses = [];

    /***
     * AvailableActions constructor.
     * @param Task $task
     * @param User $target_user
     */
    public function __construct(Task $task, User $target_user)
    {
        $this->task = $task;
        $this->target_user = $target_user;
    }

    /**
     * @return int
     */

    public function getCurrentStatus(): int
    {
        return $this->task->status_id;
    }

    /***
     * @return int
     */

    public function getNextStatus(): int
    {
        return $this->next_status;
    }

    /**
     * @return int
     */

    public function getUserRole(): int
    {
        return $this->task->user->role_id;
    }

    /**
     * @return int
     */

    public function getExecutorRole(): int
    {
        return $this->task->executor->role_id;
    }

    /***
     * @param int $user_role
     * @param array $roles
     * @return bool
     */

    protected static function checkRole(int $user_role, array $roles): bool
    {
        return in_array($user_role, $roles);
    }

    /***
     * Set next status for Task
     */

    public function setNextStatus()
    {
        if (!self::checkRole($this->target_user->role_id, $this->roles)) {
            throw new StatusException('У вас недостаточно прав');
        }

        if ($this->task->status_id === $this->next_status) {
            throw new StatusException('Статус задания уже обновлен');
        }

        if (!self::checkAccessStatus($this->getCurrentStatus(), $this->access_statuses)) {
            throw new StatusException('Ошибка смены статуса');
        } else {
            $this->task->status_id = $this->next_status;
        }
    }

    public static function checkAccessStatus(int $current_status, array $access_statuses)
    {
        return in_array($current_status, $access_statuses);
    }

    /**
     * Apply changes for task
     */
    abstract function apply(): void;
}
