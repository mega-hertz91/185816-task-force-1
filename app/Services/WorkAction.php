<?php


namespace App\Services;

class WorkAction extends AvailableActions
{
    protected $name = 'work';
    protected $roles = ['admin', 'customer'];
    protected $statuses = [self::FAILED, self::COMPLETE];

    public function getAction()
    {
        return ucfirst(self::WORK) . 'Action';
    }

    public function getName()
    {
        return self::WORK;
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
