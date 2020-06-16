<?php

namespace frontend\controllers\cabinet;

use common\models\User;
use frontend\controllers\BaseController;
use frontend\forms\UserSettingsForm;
use frontend\services\UserAdditionService;
use Yii;

class SettingsController extends BaseController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);
        $formModel = UserSettingsForm::create($user);
        $request = Yii::$app->request->post();

        if ($formModel->load($request)) {
            if ($formModel->password_new !== $formModel->password_verify) {
                Yii::$app->session->setFlash('error', 'Пароли не совпадают');
                return Yii::$app->response->redirect(['cabinet/settings']);
            } else {
                $formModel->avatar = $formModel->upload();
                $user->attributes = $formModel->getAttributes();
                $user->password = Yii::$app->security->generatePasswordHash($formModel->password_new);
                $newUser = new UserAdditionService($user);
                $newUser->update();

                Yii::$app->session->setFlash('success', 'Данные успешно обновлены');
                return Yii::$app->response->redirect(['cabinet/settings']);
            }
        }

        return $this->render('settings', [
            'formModel' => $formModel,
            'user' => $user
        ]);
    }
}
