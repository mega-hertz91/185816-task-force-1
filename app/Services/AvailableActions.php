<?php

namespace Services;

use Models\Roles;
use Models\Users;
use Models\Tasks;
use Models\Responses;

abstract class AvailableActions
{
    protected $statuses = [
        'public' => ['work, cancel'],
        'cancel' => null,
        'work' => ['complete, failed'],
        'complete' => null,
        'failed' => null
    ];

    abstract protected function getAction();
    abstract protected function checkPermission($user);
    abstract protected function getName();

    public function checkPermissionUser($id, $check_roles) {
        $users = new Users();
        $roles = new Roles();
        $user = $users->getUser($id);
        $role = $roles->getRole($user->id);

        $result = '';

        if(in_array($role->role, $check_roles) === true) {
            $result = "У рользователя: " . $user->full_name . " есть права на публикацию." . " Доступные действия: " . $role->actions;
        } else {
            $result = "У рользователя: " . $user->full_name . " не достаточно прав" ;
        }

        return $result;
    }

    public function nextStatus($status)
    {
        $result = '';

        if(array_key_exists($status, $this->statuses) === true) {
            $result = $this->statuses[$status];
        }  else {
            $result = 'Статуса ' . $status . ' не найдено';
        }

        return $result;
    }
}
