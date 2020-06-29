<?php


namespace frontend\controllers;


use common\models\Auth;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use common\models\User;

class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $nickname = ArrayHelper::getValue($attributes, 'login');

        /* @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $id,
        ])->one();

        var_dump($this->client->getUserAttributes());
        die();
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        $attributes = $this->client->getUserAttributes();
        $github = ArrayHelper::getValue($attributes, 'login');
        if ($user->github === null && $github) {
            $user->github = $github;
            $user->save();
        }
    }
}
