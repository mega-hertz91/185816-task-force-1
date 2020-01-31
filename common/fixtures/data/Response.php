<?php

use Faker\Factory;
$faker = Factory::create();

$COUNT = 600;

function getResponse($faker) {
    $date = $faker->dateTimeInInterval('-1 year', '+1 year', null);
    return [
        'user_id' => rand(1, 200),
        'amount' => rand(1000, 200000),
        'task_id' => rand(1, 100),
        'created_at' => $date->format('Y-m-d H:i:s')
    ];
}

$messages = [];

for ($i = 0; $i < $COUNT; $i++) {
    $messages[] = getResponse($faker);
}

return $messages;
