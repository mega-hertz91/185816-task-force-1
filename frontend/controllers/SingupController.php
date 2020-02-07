<?php


namespace frontend\controllers;


use frontend\forms\SingupForm;
use frontend\models\City;
use frontend\models\User;
use yii\web\Controller;
use Yii;

class SingupController extends Controller
{
    public function actionIndex ()
    {
        $this->layout = 'landing';
        $model = new SingupForm();
        $request = Yii::$app->request->post();
        $session = Yii::$app->session;
        $user = new User;

        if ($model->load($request)) {
            if ($model->validate()) {
                try {
                    $user->attributes = $model->attributes;
                    $user->save();
                    $session->setFlash('reg','Вы успешно зарегистрировались');
                    return $this->redirect('/');
                } catch (\Exception $e) {
                    $e->getMessage();
                }
            }
        }

        return $this->render('index',
            [
                'model' => $model,
                'cities' => City::find()->select(['name'])->indexBy('id')->column(),
            ]);
    }
}
