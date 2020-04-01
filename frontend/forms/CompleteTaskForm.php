<?php


namespace frontend\forms;

use yii\base\Model;

class CompleteTaskForm extends Model
{
    public $completed;
    public $description;
    public $rating;
    const SUCCESS = 1;

    public function attributeLabels()
    {
        return [
            'completed' => 'Готово',
            'description' => 'Комментарий',
            'rating' => 'Оценка'
        ];
    }

    public function rules()
    {
        return [
            [['description', 'rating', 'completed'], 'required'],
            ['rating', 'integer', 'min' => 1]
        ];
    }

    public function isCompleted()
    {
        return intval($this->completed) === self::SUCCESS;
    }
}
