<?php


namespace frontend\controllers;


use frontend\forms\UsersForm;
use frontend\models\Category;
use frontend\models\CategoryExecutor;
use frontend\models\Comment;
use frontend\models\User;
use frontend\providers\UsersProvider;
use frontend\services\TimeService;
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
}
