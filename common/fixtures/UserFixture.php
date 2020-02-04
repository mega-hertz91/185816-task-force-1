<?php
namespace common\fixtures;

use yii\test\ActiveFixture;
use frontend\models\User;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
    public $depends = [RoleFixture::class, UserStatusFixture::class, CityFixture::class];
}
