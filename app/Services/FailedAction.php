<?php


namespace Services;


class FailedAction extends AvailableActions
{
    protected $name = 'failed';
    protected $roles = ['admin', 'executor'];

    public function getAction()
    {
        // TODO: Implement getAction() method.

        return self::class;
    }

    public function getName()
    {
        // TODO: Implement getName() method.

        return $this->name;
    }

    public function checkPermission($id)
    {
        // TODO: Implement checkPermission() method.

        return $this->checkPermissionUser($id, $this->roles);

    }

    public function nextAction() {
        return parent::nextStatus($this->name);
    }
}
