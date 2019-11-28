<?php

namespace App\Services;

use App\Exceptions\RoleException;
use App\Exceptions\StatusException;

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

    protected function getClass(string $class): string
    {
        $result = explode('\\', $class);
        return end($result);
    }

    private function getRoles(): array
    {
        $roles = [self::ADMIN_ROLE, self::CUSTOMER_ROLE, self::EXECUTOR_ROLE];

        return $roles;
    }

    protected function checkPermissionUser($user, array $roles): bool
    {
        if (in_array($user->role, $roles)) {
            return in_array($user->role, $roles);
        } else {
            throw new RoleException();
        }
    }

    protected function getAvailableActions($user, $roles, array $statuses = ['null']): string
    {
        $result = '';

        try {
            if ($this->checkPermissionUser($user, $roles) === true) {
                $result = 'Для пользователя ' . $user->name . ' с ролью ' . $user->role . ' доступны действия: ' . implode(', ', $statuses);
            } else {
                $result = 'Для пользователя ' . $user->name . ' с ролью ' . $user->role . ' запрещены действия';
            }


        } catch (RoleException $e) {
            echo 'Такой роли не существует <br>';
        }
        return $result;
    }

    public static function nextStatus(string $class): string
    {
        $result = '';

        if (class_exists($class)) {

            $target  = new $class;

            if (isset($target->statuses)) {
                $result = 'Текущий класс: ' . $target->getAction() . '<br>' . 'Следующий статус: ' . implode(', ', $target->statuses);
            } else {
                $result = 'Текущий класс: ' . $target->getAction() . '<br>' . 'Доступных действий нет';
            }
        } else {
            throw new StatusException();
        }

        return $result;
    }
}
