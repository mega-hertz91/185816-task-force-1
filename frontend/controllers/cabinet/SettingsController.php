<?php

namespace frontend\controllers\cabinet;

use frontend\controllers\BaseController;

class SettingsController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('settings');
    }
}
