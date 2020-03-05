<?php


namespace frontend\forms;


use yii\base\Model;

class CreateTask extends Model
{
    public $title;
    public $description;
    public $category;
    public $budget;
    public $deadline;

    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'budget' => 'Бюджет',
            'deadline' => 'Срок исполнения'
        ];
    }
}
