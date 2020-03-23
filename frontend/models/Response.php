<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "response".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $amount
 * @property string|null $message
 * @property int|null $task_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 *
 * @property User $user
 * @property Task $task
 */
class Response extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DISABLED = 'disabled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'task_id'], 'integer'],
            [['created_at', 'updated_at', 'status'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'task_id' => 'Task ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /***
     * @return string
     */

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /***
     * @return string
     */

    public function isDisabled()
    {
        return $this->status;
    }

    /***
     * @param $id
     * @return int
     */

    public static function getActiveCountResponses($id)
    {
        $result = [];

        $responses =  Response::find()->where(['task_id'=> $id])->all();

        foreach ($responses as $item) {
            if ($item->isActive()) {
                array_push($result, $item);
            }
        }

        return count($result);
    }

    /***
     * @return bool
     */
    public function refuseResponse()
    {
        $this->status = self::STATUS_DISABLED;
        return $this->save();
    }

    public function addNewResponse($task, $message, $amount)
    {

    }
}
