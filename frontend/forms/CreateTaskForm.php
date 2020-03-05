<?php


namespace frontend\forms;


use yii\base\Model;

class CreateTaskForm extends Model
{
    public $subject;
    public $description;
    public $category;
    public $budget;
    public $deadline;

    public function attributeLabels()
    {
        return [
            'subject' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'budget' => 'Бюджет',
            'deadline' => 'Срок исполнения'
        ];
    }

    public function rules()
    {
        return [
            [['title', 'subject', 'description', 'category', 'budget', 'deadline'], 'required'],
            ['budget', 'integer'],
            ['deadline', 'date']
        ];
    }
}
