<?php


class Tasks
{
    const ADMIN = [
        'role' => 'admin',
        'actions' => ['success', 'disable', 'send', 'deleted', 'public'],
    ];

    const EXECUTOR = [
        'role' => 'executor',
        'actions' => ['success', 'disable', 'send'],
    ];
    const CUSTOMER =  [
        'role' => 'customer',
        'actions' => ['deleted', 'public'],
    ];

    protected $task = [
        'id_executor' => '',
        'id_customer' => '',
        'finish_date' => '',
        'status' => ''
    ];

    const STATUS_OPEN = 'open';
    const STATUS_ACTIVE = 'active';
    const STATUS_CLOSE = 'close';
    const STATUS_ERROR = 'error';

    const ACTION_SUCCESS = 'success';
    const ACTION_DISABLE = 'disable';
    const ACTION_SEND = 'send';
    const ACTION_DELETED = 'deleted';
    const ACTION_PUBLIC = 'public';

    public static function getRole($role) {
        if($role === 'admin') {
            return self::ADMIN;
        } elseif ($role === 'executor') {
            return self::EXECUTOR;
        } elseif ($role === 'customer') {
            return self::CUSTOMER;
        }

        return null;
    }

    public function getPropertyTask() {
        return $this->task;
    }

    public function setPropertyTask($id_executor, $id_customer, $finish_date, $status) {
        $this->task['id_executor'] = $id_executor;
        $this->task['id_customer'] = $id_customer;
        $this->task['finish_date'] = $finish_date;
        $this->task['status'] = $status;

        return $this->task;
    }

    public function getStatusTask() {
        return $this->task['status'];
    }

    public function setActionTask($action) {
        if($action === self::ACTION_SUCCESS) {
            return $this->task['status'] = self::STATUS_ACTIVE;
        } elseif($action === self::ACTION_DISABLE) {
            return $this->task['status'] = self::STATUS_CLOSE;
        }
        elseif($action === self::ACTION_SEND) {
            return $this->task['status'] = self::STATUS_OPEN;
        } elseif($action === self::ACTION_DISABLE) {
            return $this->task['status'] = self::STATUS_CLOSE;
        }
        elseif($action === self::ACTION_DELETED) {
            return $this->task['status'] = self::STATUS_CLOSE;
        } elseif($action === self::ACTION_PUBLIC) {
            return $this->task['status'] = self::STATUS_ACTIVE;
        }

        return null;
    }
}


$result = new Tasks();
$result->setPropertyTask('1', '5', '29-12-2019', 'active');
echo '<br>';
$result->setActionTask('send');
var_dump($result->getPropertyTask());
