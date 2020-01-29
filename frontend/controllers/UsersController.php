<?php


namespace frontend\controllers;


use frontend\forms\UsersFilter;
use frontend\models\Task;
use frontend\models\User;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\web\Controller;
use Yii;

class UsersController extends Controller
{
    private $cat;
    private $search;

    private function getUsers(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ]
        ]);
    }

    private function buildFilterQuery(): ActiveDataProvider
    {
        $query = User::find();

        /* if (!empty($this->cat)) {
             $query->where([
                 'category_id' => $this->cat,
             ]);
         }*/

        if (!empty($this->search)) {
            $query->andWhere([
                'like', 'full_name', $this->search
            ]);
        }

        return $this->getUsers($query);
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $users = User::find()->all();

        if ($request->isPost) {
            $this->search = $request->post()['UsersFilter']['search'];

            $users = $this->buildFilterQuery()->getModels();
        }

        return $this->render('index', [
            'title' => 'Исполнители',
            'users' => $users,
            'model' => new UsersFilter(),
            'post' => $request->post()
        ]);
    }
}
