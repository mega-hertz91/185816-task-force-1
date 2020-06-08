<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $full_name
 * @property string|null $email
 * @property int $role_id
 * @property int $city_id
 * @property int $user_status_id
 * @property string|null $date_birth
 * @property string|null $about
 * @property string|null $password
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $messenger
 * @property int|null $hidden
 * @property int|null $view_only_customer
 * @property float $rating
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CategoryExecutor[] $categoryExecutors
 * @property Comment[] $comments
 * @property Comment[] $comments0
 * @property Message[] $messages
 * @property Notice[] $notices
 * @property Response[] $responses
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property City $city
 * @property Role $role
 * @property UserStatus $userStatus
 * @property UserSettings[] $userSettings
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'role_id', 'city_id', 'user_status_id'], 'required'],
            [['role_id', 'city_id', 'user_status_id', 'hidden', 'view_only_customer'], 'integer'],
            [['date_birth', 'created_at', 'updated_at'], 'safe'],
            [['about', 'messenger'], 'string'],
            [['rating'], 'number'],
            [['full_name', 'email', 'password'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['skype'], 'string', 'max' => 100],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
            [['user_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserStatus::className(), 'targetAttribute' => ['user_status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'role_id' => 'Role ID',
            'city_id' => 'City ID',
            'user_status_id' => 'User Status ID',
            'date_birth' => 'Date Birth',
            'about' => 'About',
            'password' => 'Password',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'messenger' => 'Messenger',
            'hidden' => 'Hidden',
            'view_only_customer' => 'View Only Customer',
            'rating' => 'Rating',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryExecutors()
    {
        return $this->hasMany(CategoryExecutor::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['executor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments0()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['sender' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotices()
    {
        return $this->hasMany(Notice::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['executor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::className(), ['user_id' => 'id']);
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
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserStatus()
    {
        return $this->hasOne(UserStatus::className(), ['id' => 'user_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSettings()
    {
        return $this->hasMany(UserSettings::className(), ['user_id' => 'id']);
    }
}
