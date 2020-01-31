<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class CommentFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\Comment';
    public $depends = ['common\fixtures\UserStatusFixture', 'common\fixtures\TaskFixture'];
}
