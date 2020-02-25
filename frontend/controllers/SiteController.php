<?php
namespace frontend\controllers;

use frontend\forms\SinginForm;
use frontend\helpers\AccessSettings;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\Task;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use Faker\Factory;

/**
 * Site controller
 */
class SiteController extends BaseController
{

    public $model;

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'landing';
        $request = Yii::$app->request->post();
        $session = Yii::$app->session;
        $model = new SinginForm();
        $this->model = $model;

        if ($model->load($request)) {
            if ($model->validate()) {
                $user = $model->getUser();
                \Yii::$app->user->login($user);
                $session->setFlash('success', "Добро пожаловать $user->full_name");
                return $this->goHome();
            } else {
                $session->setFlash('error', "Логин или паротль не совпадают");
            }
        }

        return $this->render('index',
            [
                'tasks' => Task::find()->orderBy(['created_at' => SORT_DESC])->limit(4)->all(),
                'model' => $model
            ]
        );
    }
}
