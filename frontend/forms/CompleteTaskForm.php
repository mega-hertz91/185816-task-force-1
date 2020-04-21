<?php


namespace frontend\forms;

use yii\base\Model;

class CompleteTaskForm extends Model
{
    public $description;
    public $rating;

    public function attributeLabels()
    {
        return [
            'description' => 'Комментарий',
            'rating' => 'Оценка'
        ];
    }

    public function rules()
    {
        return [
            [['description', 'rating'], 'required'],
            ['rating', 'integer', 'min' => 1]
        ];
    }
}
