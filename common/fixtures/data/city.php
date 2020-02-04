<?php

use Faker\Factory;
$faker = Factory::create();

$count = 100;

$cities = [];

for ($i = 0; $i < $count; $i++) {
    $cities[] = ['name' => $faker->city];
}

return $cities;
