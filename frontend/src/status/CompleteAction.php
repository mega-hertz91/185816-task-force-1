<?php


namespace frontend\src\status;


class CompleteAction extends AvailableActions
{
    protected $roles = [self::ROLE_ADMIN, self::ROLE_CUSTOMER];
    protected $next_status = self::STATUS_COMPLETE;
    protected $access_statuses = [self::STATUS_WORK];

    public function apply(): void
    {
        $this->setNextStatus();
        $this->task->save();
        // TODO: Implement apply() method.
    }
}
