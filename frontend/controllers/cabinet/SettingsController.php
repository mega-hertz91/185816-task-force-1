<?php

namespace frontend\controllers\cabinet;

use common\models\User;
use frontend\controllers\BaseController;
use frontend\forms\UserSettingsForm;
use frontend\services\UserAdditionService;
use Yii;
use yii\db\Exception;

class SettingsController extends BaseController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);
        $formModel = UserSettingsForm::create($user);
        $request = Yii::$app->request->post();
        $userSave = new UserAdditionService($user);

        if ($formModel->load($request)) {
            $formModel->avatar = $formModel->upload();
            $user->attributes = $formModel->getAttributes();

            $userSave->updateSpecials();
            die();

            $user->save();
            Yii::$app->session->setFlash('success', 'Данные успешно обновлены');
            return Yii::$app->response->redirect(['cabinet/settings/']);
        }

        return $this->render('settings', [
            'formModel' => $formModel,
            'user' => $user
        ]);
    }
}
