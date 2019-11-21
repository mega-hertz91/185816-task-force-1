<?php


namespace App\Services;


class PublicAction extends AvailableActions
{
    protected $roles = ['admin', 'customer'];
    protected $statuses = [self::WORK, self::CANCEL];

    public function getAction()
    {
        return ucfirst(self::PUBLIC) . 'Action';
    }

    public function getName()
    {
        return self::PUBLIC;
    }

    public function checkPermission($user)
    {
        return parent::checkPermissionUser($user, $this->roles);
    }

    public function getActions($user) {
        $response = parent::getAvailableActions($user, $this->roles, $this->statuses);

        return 'Текущий класс: ' .$this->getAction() . "<br><br>" . $response;
    }
}
