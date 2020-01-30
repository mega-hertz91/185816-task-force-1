<?php

namespace frontend\forms;

use yii\base\Model;

class TasksForm extends Model
{
    public $categories;
    public $additionally;
    public $period;
    public $search;

    public function rules()
    {
        return [
            [['categories', 'additionally', 'period', 'search'], 'safe'],
        ];
    }
}
