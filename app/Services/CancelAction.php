<?php


namespace App\Services;


class CancelAction extends AvailableActions
{
    protected $roles = ['admin', 'customer'];

    public function getAction()
    {
        return ucfirst(self::CANCEL) . 'Action';
    }

    public function getName()
    {
        return self::CANCEL;
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
