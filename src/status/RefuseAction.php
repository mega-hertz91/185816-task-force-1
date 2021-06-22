<?php

namespace src\status;


use src\exceptions\StatusException;

class RefuseAction extends AvailableActions
{
    protected $roles = [self::ROLE_ADMIN, self::ROLE_EXECUTOR];
    protected $nextStatus = self::STATUS_FAILED;
    protected $accessStatuses = [self::STATUS_WORK];

    public function finishedFailed(): void
    {
        $this->roles = [self::ROLE_ADMIN, self::ROLE_CUSTOMER];
    }

    public function checkPermission(): void
    {
        if (!$this->task->isUserExecutor($this->currentUser)) {
            throw new StatusException('Доступ запрещен, обратитесь к администратору');
        }
    }
}
