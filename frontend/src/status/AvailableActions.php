<?php

namespace frontend\src\status;

use frontend\models\Task;
use frontend\src\exceptions\StatusException;
use yii\base\Exception;
use yii\web\NotFoundHttpException;

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
    protected $next_status = 0;
    protected $access_statuses = [];

    //1. Загружаем необходимые данные (user, task)
    //2. Проверяем статус задания
    //3. Проверяем доступные действия
    //4. Выполняем переход на следующий статус

    //Локальные методы:
    //1. Проверка текущего статуса
    //2. Проверка текущей роли
    //3. Проверка следующего статуса

    /***
     * AvailableActions constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
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
