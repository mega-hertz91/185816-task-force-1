<?php


namespace frontend\providers;


use frontend\models\User;
use yii\data\ActiveDataProvider;

class UsersProvider extends Provider
{
    public static function getContent(array $attributes): ActiveDataProvider
    {
        $query = User::find();

        // Временно убрал, потому что нет у юзеров пока категории

        /*if (!empty($attributes['categories'])) {
            $query->where([
                'category_id' => $attributes['categories'],
            ]);
        }*/

        if (!empty($attributes['search'])) {
            $query->andWhere([
                'like', 'full_name', $attributes['search']
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
