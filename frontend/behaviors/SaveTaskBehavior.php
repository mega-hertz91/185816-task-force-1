<?php

namespace frontend\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class SaveTaskBehavior extends Behavior
{
    const DEFAULT_STATUS = 5;

    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT => 'assignDefaultStatus'
        ];
    }

    public function assignDefaultStatus($event)
    {
        var_dump($event->data);
    }
}
