<?php
namespace common\fixtures;

use frontend\models\Message;
use frontend\models\UserStatus;
use yii\test\ActiveFixture;

class MessageFixture extends ActiveFixture
{
    public $modelClass = Message::class;
    public $depends = [UserStatusFixture::class, TaskFixture::class];
}
