<?php

namespace frontend\controllers\cabinet;

use frontend\controllers\BaseController;

class TasksController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('tasks');
    }
}
