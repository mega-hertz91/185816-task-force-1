<?php

use App\Services\SeedUser;
use App\Services\SeedCity;
use App\Services\SeedCategory;
use App\Services\SeedUserStatus;
use App\Services\SeedRole;
use App\Services\SeedStatus;
use App\Services\SeedResponse;

error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';

$user = new \stdClass();
$user->role = 'gfhgf';
$user->name = 'Jeffry Jones';


echo "<br><br>";

$file = __DIR__ . '/data/responses.csv';

$csv = new SeedResponse($file);
echo "<pre>";
print_r($csv->getSQL());
