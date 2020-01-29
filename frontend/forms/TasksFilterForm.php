<?php

namespace frontend\forms;

use frontend\models\Task;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class TasksFilterForm extends Model
{
    public $categories;
    public $additionally;
    public $period;
    public $search;

   public function rules()
    {
        return [
            [
                'categories',
                'additionally',
                'period',
                'search'
            ],'safe'
        ];
    }

    private function getTasks(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
    }

    private function buildFilterQuery(): ActiveDataProvider
    {
        $query = Task::find();

        if (!empty($this->cat)) {
            $query->where([
                'category_id' => $this->cat,
            ]);
        }

        if (!empty($this->period)) {
            $query->andWhere([
                '>=', 'created_at', 'asd'
            ]);
        }

        if (!empty($this->search)) {
            $query->andWhere([
                'like', 'title', $this->search
            ]);
        }

        return $this->getTasks($query);
    }
}
