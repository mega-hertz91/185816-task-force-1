<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class MessageFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\Message';
    public $depends = ['common\fixtures\UserStatusFixture', 'common\fixtures\TaskFixture'];
}
