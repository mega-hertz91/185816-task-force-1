<?php


namespace frontend\src\status;

use frontend\models\Task;
use frontend\src\exceptions\StatusException;
use Yii;

class CancelAction extends AvailableActions
{
    protected $roles = [self::ROLE_ADMIN, self::ROLE_CUSTOMER];
    protected $next_status = self::STATUS_CANCEL;
    protected $access_statuses = [self::STATUS_WORK];

    public function apply(): void
    {
        $this->setNextStatus();
        $this->task->save();
    }
}
