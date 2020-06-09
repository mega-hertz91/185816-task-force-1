<?php


namespace frontend\controllers;


use common\models\CategoryExecutor;
use frontend\forms\UsersForm;
use common\models\Category;
use common\models\Comment;
use common\models\User;
use frontend\providers\UsersProvider;
use Yii;
use yii\web\NotFoundHttpException;

class UsersController extends BaseController
{

    public function actionIndex()
    {
        $form = new UsersForm();
        $request = Yii::$app->request->post();

        if ($form->load($request)) {
            $form->attributes = $request['UsersForm'];
        }

        return $this->render('index', [
            'users' => UsersProvider::getContent($form->attributes),
            'categories' => Category::find()->select(['category_name'])->indexBy('id')->column(),
            'model' => $form
        ]);
    }

    public function actionView($id)
    {
        $user = User::findOne($id);
        if (Comment::find()->where(['executor_id' => $id])->exists()) {
            $comments = Comment::find()->where(['executor_id' => $id])->all();
        } else {
            $comments = null;
        }

        if ($user === null) {
            throw new NotFoundHttpException('Такого пользователя не существует');
        }

        return $this->render('user', [
            'user' => $user,
            'comments' => $comments
        ]);
    }

    public function actionTest()
    {
        //$users = CategoryExecutor::find()->select(['user_id', 'category_id', 'count' => 'count(user_id)'])->with('user' )->groupBy(['user_id'])->where(['category_id' => 1])->all();
        $cats = CategoryExecutor::find()->select(['count(user_id) as cnt'])->groupBy(['user_id'])->asArray()->all();
        $provider = UsersProvider::getContent();

        var_dump(CategoryExecutor::find()->select(['user_id', 'count' => 'count(user_id)'])->with('user')->groupBy(['user_id'])->all());

        /*foreach ($provider as $user) {
            var_dump($user);
        }*/
    }
}
