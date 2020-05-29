<?php

namespace frontend\controllers\cabinet;

use frontend\controllers\BaseController;
use frontend\forms\UserSettingsForm;
use frontend\models\User;
use Yii;

class SettingsController extends BaseController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);
        $formModel = new UserSettingsForm();
        $request = Yii::$app->request->post();

        if ($formModel->load($request) && $formModel->validate()) {
            var_dump($formModel->attributes);
        }

        return $this->render('settings', [
            'formModel' => $formModel,
            'user' => $user
        ]);
    }
}
