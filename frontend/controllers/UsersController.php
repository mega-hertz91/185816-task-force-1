<?php


namespace frontend\controllers;


use frontend\forms\UsersForm;
use frontend\models\Category;
use frontend\models\User;
use frontend\providers\UsersProvider;
use yii\web\Controller;
use Yii;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $form = new UsersForm();
        $request = Yii::$app->request->post();

        if($form->load($request)) {
            $form->attributes = $request['UsersForm'];
        }

        return $this->render('index', [
            'users' => UsersProvider::getContent($form->attributes)->getModels(),
            'categories' => Category::find()->select(['category_name'])->indexBy('id')->column(),
            'model' => $form
        ]);
    }
}
