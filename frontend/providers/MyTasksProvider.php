<?php

namespace frontend\providers;

use frontend\models\Task;
use frontend\models\User;
use phpDocumentor\Reflection\Types\Integer;
use yii\data\ActiveDataProvider;
use yii\web\IdentityInterface;

class MyTasksProvider extends Provider
{
    const SIZE_ELEMENT = 10;

    protected static function getDate($period)
    {
        $now = strtotime('now');
        $diff = $now - $period;

        return date('Y-m-d H:i:s', $diff);
    }

    /***
     * @param array $attributes
     * @return ActiveDataProvider
     */

    public static function getContent(array $attributes): ActiveDataProvider
    {
        $query = Task::find()->where($attributes)->with(['city', 'category', 'user']);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::SIZE_ELEMENT
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);
    }

    /**
     * @param array $attributes
     * @param User $user
     * @param bool $failed
     * @param string $date
     * @return ActiveDataProvider
     */

    public static function getCommonContent(array $attributes, $user, $failed = false, $date = false)
    {
        $query = Task::find()->where($attributes)->with(['city', 'category', 'user']);

        if ($user->role_id === User::CUSTOMER) {
            $query->andWhere(['user_id' => $user->id]);
        }

        if ($user->role_id === User::EXECUTOR) {
            $query->andWhere(['executor_id' => $user->id]);
        }

        if ($failed) {
            $query->orWhere(['status_id' => Task::STATUS_FAILED]);
        }

        if ($date) {
            $query->andWhere(['<' , 'deadline', $date]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::SIZE_ELEMENT
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);
    }
}
