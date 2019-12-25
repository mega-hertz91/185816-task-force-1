<?php

error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';

$user = new \stdClass();
$user->role = 'gfhgf';
$user->name = 'Jeffry Jones';

$files = [
    '/data/categories.csv' => 'Category',
    '/data/cities.csv' => 'City',
    '/data/roles.csv' => 'Role',
    '/data/user-status.csv' => 'UserStatus',
    '/data/statuses.csv' => 'Status',
    '/data/users.csv' => 'User',
    '/data/tasks.csv' => 'Task',
    '/data/comments.csv' => 'Comment',
    '/data/messages.csv' => 'Message',
    '/data/responses.csv' => 'Response'
];

echo "<br><br>";

foreach ($files as $file => $class) {
    $file = __DIR__ . $file;
    $class = "App\Services\Seed$class";

    try {
        echo $class . " success seed class <br>";

        $csv = new $class($file);
        $csv->getSQL();
    } catch (Exception $e) {
        echo "<br>";
       print_r("<p style='margin: 0; border: 1px solid crimson; padding: 2px 5px; display: inline-block'>".$e->getMessage() . "</p><br>");
    }
}
