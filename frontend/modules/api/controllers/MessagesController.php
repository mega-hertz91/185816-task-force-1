<?php

namespace app\modules\api\controllers;

use frontend\models\Message;
use yii\rest\ActiveController;

/**
 * Messages controller for the `api` module
 */
class MessagesController extends ActiveController
{
    public $modelClass = Message::class;
}
