<?php


namespace frontend\forms;


use common\models\UploadFileTrait;
use Yii;
use yii\base\Model;

class PhotoJobForm extends Model
{
    use UploadFileTrait;

    public $user_id;
    public $img;

    public function rules()
    {
        return [
            [['user_id', 'photos'], 'required'],
            ['user_id', 'integer'],
            [['photos'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 6 ],
        ];
    }
    public function init()
    {
        $this->user_id = Yii::$app->user->id;
        parent::init();
    }
}
