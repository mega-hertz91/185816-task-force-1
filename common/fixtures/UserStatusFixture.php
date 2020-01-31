<?php

namespace common\fixtures;

use yii\test\ActiveFixture;

class UserStatusFixture extends ActiveFixture
{
    public $tableName = 'user_status';
    public $modelClass = 'frontend\models\UserStatus';
}
