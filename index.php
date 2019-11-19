<?php

require_once __DIR__ . '/vendor/autoload.php';

use Models\Roles;
use Services\CompleteAction;

/*$role = new Roles();
//$response = mysqli_connect('task-force.academy', 'admin', 'admin', 'taskforce');
var_dump($role->getRole(1));*/

$method = new CompleteAction();
var_dump($method->checkPermission(1));
