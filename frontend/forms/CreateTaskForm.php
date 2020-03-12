<?php


namespace frontend\forms;


use yii\base\Model;

class CreateTaskForm extends Model
{
    const DEFAULT_STATUS = 1;
    const DEFAULT_CITY = 1;

    public $title;
    public $description;
    public $category_id;
    public $budget;
    public $deadline;

    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category_id' => 'Категория',
            'budget' => 'Бюджет',
            'deadline' => 'Срок исполнения'
        ];
    }

    public function rules()
    {
        return [
            [['title','description', 'category_id', 'budget', 'deadline'], 'required', 'message' => 'Поле не может быть пустым'],
            ['budget', 'integer', 'message' => 'Поле должно быть числом'],
            ['deadline', 'datetime', 'format' => 'php:Y-m-d H:i', 'message' => 'Введите дату в правильном формате YYYY-mm-dd hh:mm']
        ];
    }
}
