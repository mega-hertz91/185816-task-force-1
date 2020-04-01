<?php


namespace frontend\forms;


use yii\base\Model;

class NewResponseForm extends Model
{
    public $amount;
    public $message;

    public function attributeLabels()
    {
        return [
            'amount' => 'Ваша цена',
            'message' => 'Комментарий'
        ];
    }

    public function rules()
    {
        return [
            [['amount', 'message'], 'required'],
            ['amount', 'number', 'min' => 1],
            ['message', 'string', 'min' => 10]
        ];
    }
}
