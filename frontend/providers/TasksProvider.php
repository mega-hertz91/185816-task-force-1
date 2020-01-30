<?php

namespace frontend\providers;

use frontend\models\Task;
use yii\data\ActiveDataProvider;

class TasksProvider extends Provider
{
    protected static function getDate($period)
    {
        $now = strtotime('now');
        $diff = $now - $period;

        return date('Y-m-d H:i:s', $diff);
    }

    public static function getContent(array $attributes): ActiveDataProvider
    {
        $query = Task::find();

        if (!empty($attributes['categories'])) {
            $query->where([
                'category_id' => $attributes['categories'],
            ]);
        }

        if (!empty($attributes['period'])) {
            $query->andWhere([
                '>=', 'created_at', self::getDate($attributes['period'])
            ]);
        }

        if (!empty($attributes['search'])) {
            $query->andWhere([
                'like', 'title', $attributes['search']
            ]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);
    }
}
