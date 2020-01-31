<?php

use Faker\Factory;
$faker = Factory::create();

$COUNT = 100;

$cities = [];

for ($i = 0; $i < $COUNT; $i++) {
    $cities[] = ['name' => $faker->city];
}

return $cities;
