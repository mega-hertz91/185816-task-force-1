<?php


namespace frontend\services;

use common\models\CategoryExecutor;
use common\models\User;
use common\models\UserSettings;
use Yii;
use yii\db\Exception;

class UserAdditionService
{
    /**
     * @var User $user
     */
    protected $user;
    /**
     * @var CategoryExecutor
     */
    protected $categoryExecutor;
    /**
     * @var UserSettings
     */
    protected $userSetting;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->categoryExecutor = CategoryExecutor::class;
        $this->userSetting = UserSettings::class;
    }

    public function generateArray($settings)
    {
        $result = [];

        foreach ($settings as $setting => $id) {
            $result[] = [$this->user->id, $id];
        }

        return $result;
    }

    /**
     * Create new relationship
     * @param CategoryExecutor|UserSettings $class
     * @param array $attributes
     * @param array $values
     * @throws Exception
     */

    public function updateSpecials($class, array $attributes, array $values): void
    {
        $class::deleteAll(['user_id' => $this->user->id]);

        $query = Yii::$app->db->createCommand()
            ->batchInsert(
                $class::tableName(),
                $attributes,
                $values
            );

        if (!$query->query()) {
            throw new Exception('Данные не сохранились');
        }
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

    /**
     * Update new user
     * @return bool|string
     */

    public function update()
    {
        try {
            $this->updateSpecials($this->categoryExecutor, ['user_id', 'category_id'], $this->generateArray($this->user->specials));
            $this->updateSpecials($this->userSetting, ['user_id', 'notice_category_id'], $this->generateArray($this->user->settings));
            $this->checkStatus();

            return $this->user->save();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
