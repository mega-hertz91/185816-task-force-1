<?php


namespace common\models;

use frontend\models\Task;
use yii\web\NotFoundHttpException;

trait TaskModelTrait
{
    public static function findOrFail(array $options)
    {
        $result = Task::findOne($options);

        if ($result === null) {
            throw new NotFoundHttpException('Задание не найдено');
        }

        return $result;
    }
}
