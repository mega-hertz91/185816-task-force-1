<?php

namespace frontend\src\status;


class FailedAction extends AvailableActions
{
    protected $roles = [self::ROLE_ADMIN, self::ROLE_EXECUTOR];
    protected $next_status = self::STATUS_FAILED;
    protected $access_statuses = [self::STATUS_WORK];

    public function finishedFailed(): void
    {
        $this->roles = [self::ROLE_ADMIN, self::ROLE_CUSTOMER];
    }

    public function apply(): void
    {
        $this->setNextStatus();
        $this->task->save();
        // TODO: Implement apply() method.
    }
}
