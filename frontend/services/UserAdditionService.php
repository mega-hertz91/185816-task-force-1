<?php


namespace frontend\services;


use common\models\CategoryExecutor;
use common\models\User;
use yii\db\Exception;

class UserAdditionService
{
    /**
     * @var User $user
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function generateArraySettings($settings)
    {
        $result = [];

        foreach ($settings as $setting => $id) {
            $result[] = [$this->user->id, $id];
        }

        return $result;
    }

    /**
     * Create new relationship
     * @throws Exception
     */

    public function updateSpecials(): void
    {
        CategoryExecutor::deleteAll(['user_id' => $this->user->id]);

        $query = \Yii::$app->db->createCommand()
            ->batchInsert(
                'category_executor',
                [
                    'user_id',
                    'category_id'
                ],
                $this->generateArraySettings($this->user->specials)
            );

        $query->query();
    }

    /**
     * Check status before save
     */

    public function checkStatus()
    {
        if (!empty($this->specials) && $this->user->role_id === $this->user::CUSTOMER) {
            $this->user->role_id = $this->user::EXECUTOR;
        } else {
            $this->user->role_id = $this->user::CUSTOMER;
        }
    }
}
