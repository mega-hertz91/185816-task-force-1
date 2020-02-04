<?php
namespace common\fixtures;

use frontend\models\Category;
use frontend\models\Task;
use yii\test\ActiveFixture;

class TaskFixture extends ActiveFixture
{
    public $modelClass = Task::class;
    public $depends = [CategoryFixture::class, UserFixture::class, CityFixture::class];
}
