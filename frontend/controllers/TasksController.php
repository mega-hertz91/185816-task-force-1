<?php

namespace frontend\controllers;

use frontend\assets\Period;
use frontend\forms\TasksFilter;
use frontend\models\Task;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\web\Controller;

class TasksController extends Controller
{
    private $cat;
    private $search;
    private $period;

    private function getTasks(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
    }

    private function getDate($tag)
    {
        $tag = ucfirst($tag);
        $method = 'get' . $tag;

        return Period::$method();
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
                '>=', 'created_at', $this->getDate($this->period)
            ]);
        }

        if (!empty($this->search)) {
            $query->andWhere([
                'like', 'title', $this->search
            ]);
        }

        return $this->getTasks($query);
    }

    public function actionIndex()
    {
        $tasks = Task::find()->where(['status_id' => 5])->all();
        $title = 'Tasks';
        $request = Yii::$app->request;

        foreach ($tasks as $task) {
            $task->created_at = Yii::$app->formatter->asDate($task->created_at);
        }

        if ($request->isPost) {
            $this->cat = $request->post()['TasksFilter']['categories'];
            $this->period = $request->post()['TasksFilter']['period'];
            $this->search = $request->post()['TasksFilter']['search'];


            $tasks = $this->buildFilterQuery()->getModels();
        }

        return $this->render('index', [
            'title' => $title,
            'tasks' => $tasks,
            'model' => new TasksFilter(),
        ]);
    }
}
