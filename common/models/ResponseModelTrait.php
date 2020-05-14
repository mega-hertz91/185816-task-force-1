<?php


namespace common\models;

use frontend\models\Response;
use yii\web\NotFoundHttpException;

trait ResponseModelTrait
{
    public static function findOrFail(array $options)
    {
        $result = Response::findOne($options);

        if ($result === null) {
            throw new NotFoundHttpException('Отзыв не найден');
        }

        return $result;
    }
}
