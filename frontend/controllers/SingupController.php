<?php


namespace frontend\controllers;


use frontend\forms\SingupForm;
use frontend\models\City;
use frontend\models\User;
use phpDocumentor\Reflection\Types\Object_;
use yii\db\Exception;
use yii\web\Controller;
use Yii;

class SingupController extends Controller
{
    public function actionIndex ()
    {
        $this->layout = 'landing';
        $form = new SingupForm();
        $request = Yii::$app->request->post();
        $session = Yii::$app->session;
        $user = new User;
        $errors = [];

        if($form->load($request)) {
            $data = $request['SingupForm'];
            $email = User::find()->where(['email' => $data['email']])->all();
           if($form->validate() && empty($email)) {
               try {
                   $user->full_name = $data['name'];
                   $user->email = $data['email'];
                   $user->password = Yii::$app->getSecurity()->generatePasswordHash($data['password']);
                   $user->city_id = $data['city'];
                   $user->role_id = $user::DEFAULT_ROLE;
                   $user->user_status_id = $user::DEFAULT_STATUS;

                   $user->save();
               } catch (Exception $e){
                   echo $e->getMessage();
               }

               $session->setFlash('reg', '<div style="background-color: #00e096;"><p style="padding: 12px 15px; width: 1216px; margin: auto;" class="alert-success">Registration success</p></div>');
               return $this->redirect('/');

           } else {
               $errors = $form->errors;

               if(!empty($email)) {
                   $errors += ['email' => ['Email is already in use']] ;
               }
           }
        }

        return $this->render('index',
            [
                'form' => $form,
                'cities' => City::find()->select(['name'])->indexBy('id')->column(),
                'errors' => $errors,
            ]);
    }
}
