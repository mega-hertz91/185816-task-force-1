<?php

namespace frontend\providers;

use yii\data\ActiveDataProvider;

abstract class Provider
{
    const SIZE_ELEMENT = 10;

    abstract static function getContent(array $attributes): ActiveDataProvider;
}
