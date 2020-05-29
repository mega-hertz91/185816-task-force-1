<?php


namespace frontend\forms;


use frontend\models\City;
use frontend\models\Role;
use yii\base\Model;

class UserSettingsForm extends Model
{
    public $full_name;
    public $email;
    public $role_id;
    public $city_id;
    public $date_birth;
    public $about;
    public $password;
    public $password_verify;
    public $tel;
    public $skype;
    public $messenger;
    public $specials;
    public $setting;

    public function rules()
    {
        return [
            [['full_name', 'password'], 'required'],
            [['role_id', 'city_id', 'user_status_id'], 'integer'],
            [['date_birth'], 'safe'],
            [['about'], 'string'],
            [['full_name', 'email', 'password', 'skype', 'messenger'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Имя',
            'email' => 'Электронная почта',
            'role_id' => 'Role ID',
            'city_id' => 'Город',
            'user_status_id' => 'User Status ID',
            'date_birth' => 'Дата рождения',
            'about' => 'Информация о себе',
            'password' => 'Новый пароль',
            'password_verify' => 'Подтвердите пароль',
            'phone' => 'Телефон',
            'skype' => 'Skype',
            'rating' => 'Рейдинг',
            'messenger' => 'Messenger',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
