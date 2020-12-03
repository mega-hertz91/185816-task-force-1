<?php


namespace frontend\controllers;


use frontend\forms\SinginForm;
use frontend\forms\SingupForm;
use common\models\City;
use common\models\User;
use Yii;
use yii\web\Response;

class RegisterController extends BaseController
{
    /**
     * @var SingupForm|mixed
     */
    public $model;

    /**
     * Replace behaviors for register
     *
     * @return array|array[]
     */

    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'actions' => ['index'],
            'allow' => true,
            'roles' => ['?'],
        ];

        array_unshift($rules['access']['rules'], $rule);

        return $rules;
    }

    /**
     * Checked guest user
     *
     * @param $action
     * @return string|Response
     */
    public function beforeAction($action)
    {
        return Yii::$app->user->isGuest ?  true : Yii::$app->response->redirect(['tasks/index']);
    }

    /**
     * Register user
     *
     * @return string|Response
     */
    public function actionIndex ()
    {
        $this->layout = 'landing';
        $model = new SingupForm();
        $this->model = new SinginForm();
        $request = Yii::$app->request->post();
        $session = Yii::$app->session;
        $user = new User;

        if ($model->load($request) && $model->validate()) {
            $user->attributes = $model->attributes;
            $user->setHash();
            $user->save();
            $session->setFlash('reg','Вы успешно зарегистрировались');
            return $this->redirect('/login');
        }

        return $this->render('index',
            [
                'model' => $model,
                'cities' => City::find()->select(['name'])->indexBy('id')->column(),
            ]);
    }
}
