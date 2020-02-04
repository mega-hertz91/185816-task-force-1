<?php
namespace common\fixtures;

use frontend\models\Comment;
use frontend\models\Task;
use yii\test\ActiveFixture;

class CommentFixture extends ActiveFixture
{
    public $modelClass = Comment::class;
    public $depends = [UserStatusFixture::class, TaskFixture::class];
}
