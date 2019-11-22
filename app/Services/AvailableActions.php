<?php

namespace App\Services;

abstract class AvailableActions
{
    const WORK = 'work';
    const COMPLETE = 'complete';
    const FAILED = 'failed';
    const CANCEL = 'cancel';
    const PUBLIC = 'public';
    const ADMIN_ROLE = 'admin';
    const CUSTOMER_ROLE = 'customer';
    const EXECUTOR_ROLE = 'executor';

    abstract protected function getAction();

    abstract protected function checkPermission($user);

    abstract protected function getName();

    protected function getClass($class)
    {
        $result = explode('\\', $class);
        return end($result);
    }

    protected function checkPermissionUser($user, $roles)
    {
        return in_array($user->role, $roles);
    }

    protected function getAvailableActions($user, $roles, array $statuses = ['null'])
    {
        $result = '';

        if ($this->checkPermissionUser($user, $roles) === true) {
            $result = 'Для пользователя ' . $user->name . ' с ролью ' . $user->role . ' доступны действия: ' . implode(', ', $statuses);
        } else {
            $result = 'Для пользователя ' . $user->name . ' с ролью ' . $user->role . ' запрещены действия';
        }

        return $result;
    }

    public static function nextStatus($class)
    {
        $target = new $class;

        if (isset($target->statuses)) {
            $result = 'Текущий класс: ' . $target->getAction() . '<br>' . 'Следующий статус: ' . implode(', ', $target->statuses);
        } else {
            $result = 'Текущий класс: ' . $target->getAction() . '<br>' . 'Доступных действий нет';
        }

        return $result;
    }
}
