<?php

use App\Services\SeedUser;

error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';

$user = new \stdClass();
$user->role = 'gfhgf';
$user->name = 'Jeffry Jones';


echo "<br><br>";

$files = [
    '/data/users.csv',
    '/data/categories.csv',
    '/data/cities.csv',
    '/data/opinions.csv',
    '/data/profiles.csv',
    '/data/replies.csv',
    '/data/tasks.csv',
];

$file = __DIR__ . '/data/users.csv';

$csv = new SeedUser($file);
echo "<pre>";
print_r($csv->getSQL());

