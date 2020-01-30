<?php

namespace frontend\providers;

use yii\data\ActiveDataProvider;

abstract class Provider
{
    abstract static function getContent(array $attributes): ActiveDataProvider;
}
