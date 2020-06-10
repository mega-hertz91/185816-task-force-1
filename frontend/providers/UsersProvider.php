<?php


namespace frontend\providers;


use common\models\CategoryExecutor;
use yii\data\ActiveDataProvider;

class UsersProvider extends Provider
{

    /***
     * @param array $attributes frontend\Forms\UserForm
     * @param string $sort
     * @return ActiveDataProvider
     */

    public static function getContent(array $attributes = [], $sort = 'created_at'): ActiveDataProvider
    {
        $query = CategoryExecutor::find()
            ->alias('ce')
            ->select('user_id')
            ->innerJoinWith('user u')
            ->groupBy('ce.user_id')
        ;



        if (!empty($attributes['categories'])) {
            $query->andwhere([
                'category_id' => $attributes['categories'],
            ]);
        }

        if (!empty($attributes['search'])) {
            $query->andwhere([
                'like', 'full_name', $attributes['search']
            ]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::SIZE_ELEMENT
            ],
        ]);
    }
}
