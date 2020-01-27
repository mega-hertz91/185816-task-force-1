<?php

namespace frontend\forms;

use frontend\models\Category;
use yii\base\Model;

class TasksForm extends Model
{
    public $categories;
    public $additionally;
    public $period;
    public $search;

    private function getArrayAttr()
    {
        $categories = Category::find()->asArray()->all();
        $checkboxes = [];

        foreach ($categories as $cat) {
            $checkboxes += [$cat['tag'] => $cat['category_name']];
        }

        return $checkboxes;
    }

    public function attributeLabels()
    {
        return $this->getArrayAttr();
    }
}
