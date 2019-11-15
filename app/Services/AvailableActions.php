<?php

namespace Services;

use Models\Users;
use Models\Tasks;
use Models\Responses;

abstract class AvailableActions
{
    protected $actions = ['new', 'cancel', 'work', 'complete', 'failed'];

    abstract protected function getAction();
    abstract protected function checkPermission($user);
    abstract protected function getName();

    public function getUserActions($id, $role) {
        $user = Users::find($id);
        $response = '';

        if(in_array($user->role, $role) === true) {
            $response = $user->actions; // Вывод из модели действий
        } else {
            $response = $user->name . 'у вас не достаточно прав';
        }

        return $response;
    }
}


class NewAction extends AvailableActions
{
    const NAME = 'new';
    protected $role = ['admin', 'customer'];

    public function getName()
    {
        return self::NAME;
    }

    public function getAction()
    {
        return lcfirst(self::NAME) . 'Action';
    }

    public function checkPermission($id)
    {
        return $this->getUserActions($id, $this->role);
    }
}

class CancelAction extends AvailableActions
{
    protected $name = 'cancel';
    protected $role = ['admin', 'customer'];

    public function getName()
    {
        return $this->name;
    }

    public function getAction()
    {
        return lcfirst($this->name) . 'Action';
    }

    public function checkPermission($id)
    {
        return $this->getUserActions($id, $this->role);
    }
}

class WorkAction extends AvailableActions
{
    protected $name = 'cancel';
    protected $role = ['admin', 'customer'];
    protected $task;
    protected $customer;
    protected $executor;

    public function __construct(Tasks $task)
    {
        $this->task = $task;
        $this->customer = $task->user_id;
        $this->executor = $task->executor_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAction()
    {
        return lcfirst($this->name) . 'Action';
    }

    public function checkPermission($id)
    {
        return $this->getUserActions($id, $this->role);
    }

    public function complete($id) {
        if($this->executor === $id) {
            $this->task->status = $this->name;
        } else {
            return false;
        }
    }
}

class CompleteAction extends AvailableActions
{
    protected $name = 'complete';
    protected $role = ['admin', 'customer'];

    public function getName()
    {
        return $this->name;
    }

    public function getAction()
    {
        return lcfirst($this->name) . 'Action';
    }

    public function checkPermission($id)
    {
        return $this->getUserActions($id, $this->role);
    }
}

class FailedAction extends AvailableActions
{
    protected $name = 'failed';
    protected $role = ['admin', 'executor'];

    public function getName()
    {
        return $this->name;
    }

    public function getAction()
    {
        return lcfirst($this->name) . 'Action';
    }

    public function checkPermission($id)
    {
        return $this->getUserActions($id, $this->role);
    }
}

// Написать абстарктный класс-действие

// Реализовать от абстрактного класса наследников по общему количеству действий


// Новое Задание опубликовано, исполнитель ещё не найден
// Отменено	Заказчик отменил задание
// В работе	Заказчик выбрал исполнителя для задания
// Выполнено Заказчик отметил задание как выполненное
// Провалено Исполнитель отказался от выполнения задания
