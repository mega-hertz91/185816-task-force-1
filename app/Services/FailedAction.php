<?php


namespace App\Services;


class FailedAction extends AvailableActions
{
    protected $roles = ['admin', 'executor'];

    public function getAction()
    {
        return ucfirst(self::FAILED) . 'Action';
    }

    public function getName()
    {
        return self::FAILED;
    }

    public function checkPermission($user)
    {
        return parent::checkPermissionUser($user, $this->roles);
    }

    public function getActions($user) {
        $response = parent::getAvailableActions($user, $this->roles);

        return 'Текущий класс: ' .$this->getAction() . "<br><br>" . $response;
    }
}
