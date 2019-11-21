<?php


namespace App\Services;


class CompleteAction extends AvailableActions
{
    protected $roles = ['admin', 'executor'];

    public function getAction()
    {
        return ucfirst(self::COMPLETE) . 'Action';
    }

    public function getName()
    {
        return self::COMPLETE;
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
