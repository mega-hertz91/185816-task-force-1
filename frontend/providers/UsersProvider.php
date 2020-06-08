<?php


namespace frontend\providers;


use common\models\CategoryExecutor;
use yii\data\ActiveDataProvider;

class UsersProvider extends Provider
{
    const SIZE_ELEMENT = 10;

    /***
     * @param array $attributes frontend\Forms\UserForm
     * @param string $sort
     * @return ActiveDataProvider
     */

    public static function getContent(array $attributes, $sort = 'created_at'): ActiveDataProvider
    {
        $query = CategoryExecutor::find()->joinWith('user');

        if (!empty($attributes['categories'])) {
            $query->where([
                'category_id' => $attributes['categories'],
            ]);
        }

        if (!empty($attributes['search'])) {
            $query->where([
                'like', 'full_name', $attributes['search']
            ]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::SIZE_ELEMENT
            ],
            'sort' => [
                'defaultOrder' => [
                    $sort => SORT_DESC,
                ]
            ],
        ]);
    }
}
