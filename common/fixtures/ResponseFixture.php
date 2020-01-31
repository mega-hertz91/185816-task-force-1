<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class ResponseFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\Response';
    public $depends = ['common\fixtures\UserStatusFixture', 'common\fixtures\TaskFixture'];
}
