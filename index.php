<?php

use App\Services\CompleteAction;
use App\Services\AvailableActions;
use App\Services\WorkAction;
use App\Services\PublicAction;
use App\Services\FailedAction;
use App\Services\CancelAction;
use App\Exceptions\StatusException;
use App\Services\ParserCSV;

error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';

$user = new \stdClass();
$user->role = 'gfhgf';
$user->name = 'Jeffry Jones';

$action = new FailedAction();
$action1 = new PublicAction();
$action2 = new WorkAction();
$action3 = new CompleteAction();
$action4 = new CancelAction();
$action5 = new FailedAction();

$actions = [$action, $action1, $action2, $action3, $action4, $action5];

foreach ($actions as $action) {
    echo '<pre>';
    print 'Внутреннее имя: '. $action->getName() . '<br>';
    print 'Имя действия: ' . $action->getAction() . '<br>';
    print $action->getActions($user) . '<br>';
    echo '<hr>';
}

/*
  Проверка для следующего статуса и доступных действий
*/

try {
    print_r(AvailableActions::nextStatus('asda'));
} catch (StatusException $e) {
    echo 'Такого класса не существует';
}

echo "<br><br>";

$file = __DIR__ . '/data/users.csv';

$parse = new ParserCSV($file);
var_dump($parse->getArray());


