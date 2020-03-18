<?php

namespace frontend\models;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $title
 * @property string|null $description
 * @property int $city_id
 * @property int $user_id
 * @property int|null $executor_id
 * @property int|null $budget
 * @property string $deadline
 * @property int $status_id
 * @property string|null $file
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Comment[] $comments
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property Response[] $responses
 * @property Category $category
 * @property City $city
 * @property User $executor
 * @property Status $status
 * @property User $user
 */
class Task extends \yii\db\ActiveRecord
{

    const STATUS_DEFAULT = 5;
    const STATUS_WORK = 4;
    const STATUS_FAILED = 3;
    const MESSAGE_FAILED = 'Задание провалено';
    const RATING_DEFAULT = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'city_id', 'user_id', 'status_id'], 'required'],
            [['category_id', 'city_id', 'user_id', 'executor_id', 'budget', 'status_id'], 'integer'],
            [['description'], 'string'],
            [['deadline', 'created_at', 'updated_at'], 'safe'],
            [['title', 'file'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'description' => 'Description',
            'city_id' => 'City ID',
            'user_id' => 'User ID',
            'executor_id' => 'Executor ID',
            'budget' => 'Budget',
            'deadline' => 'Deadline',
            'status_id' => 'Status ID',
            'file' => 'File',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['recipient' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::className(), ['id' => 'executor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function init()
    {
        $this->status_id = self::STATUS_DEFAULT;
    }

    /**
     * @return int
     */

    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return int
     */

    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * @return bool
     */
    public function isDefaultStatus()
    {
        return $this->status_id === self::STATUS_DEFAULT;
    }

    /***
     * @return bool
     */

    public function isWorkStatus()
    {
        return $this->status_id === self::STATUS_WORK;
    }

    /***
     * @return bool
     */

    public function isFailedStatus()
    {
        return $this->status_id === self::STATUS_FAILED;
    }

    /***
     * @param User $executor
     * @return bool
     */

    public function changeStatusWork(User $executor)
    {
        $this->status_id = Task::STATUS_WORK;
        $this->executor_id = $executor->id;

        return $this->save();
    }

    /**
     * @param Comment $comment
     * @param User $executor
     * @return bool
     */
    public function changeStatusFailed(Comment $comment, User $executor)
    {
        $comment->task_id = $this->id;
        $comment->user_id = $this->user_id;
        $comment->executor_id = $executor->id;
        $comment->description = self::MESSAGE_FAILED;
        $comment->rating = self::RATING_DEFAULT;
        $comment->save();

        $executor->rating = $comment->getRating($executor);
        $executor->save();

        $this->status_id = Task::STATUS_FAILED;
        $this->executor_id = null;
        return $this->save();
    }
}
