<?php


namespace frontend\providers;


use common\models\CategoryExecutor;
use common\models\User;
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
        $query = CategoryExecutor::find()->select(['user_id', 'count' => 'count(user_id)'])->with('user')->groupBy(['user_id']);


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
        ]);
    }
}
