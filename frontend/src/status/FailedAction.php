<?php


namespace src\status;


class FailedAction extends AvailableActions
{
    protected $roles = [self::ADMIN_ROLE, self::EXECUTOR_ROLE];

    public function getAction()
    {
        return $this->getClass(__CLASS__);
    }

    public function getName()
    {
        return __CLASS__;
    }

    public function checkPermission($user)
    {
        return parent::checkPermissionUser($user, $this->roles);
    }

    public function getActions($user)
    {
        $response = parent::getAvailableActions($user, $this->roles);

        return 'Текущий класс: ' . $this->getAction() . "<br><br>" . $response;
    }
}
