<?php


namespace frontend\forms;

use yii\base\Model;

class SingupForm extends Model
{
    public $email;
    public $name;
    public $city;
    public $password;

    public function rules()
    {
        return [
            [
                ['email', 'name', 'city', 'password'], 'required'
            ],
        ];
    }
}
