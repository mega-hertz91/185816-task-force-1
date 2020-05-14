<?php


namespace common\fixtures;


use frontend\models\Category;
use frontend\models\User;
use yii\test\ActiveFixture;
use frontend\models\CategoryExecutor;

class CategoryExecutorFixture extends ActiveFixture
{
    public $tableName = 'category_executor';
    public $modelClass = CategoryExecutorFixture::class;
    public $depends = [CategoryFixture::class, UserFixture::class];
}
