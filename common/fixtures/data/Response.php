<?php

use Faker\Factory;
$faker = Factory::create();

$COUNT = 200;

function getResponse($faker) {
    $faker = Factory::create();
    $date = $faker->dateTimeInInterval('-1 year', '+1 year', null);
    return [
        'user_id' => rand(1, 60),
        'amount' => rand(1000, 200000),
        'message' => $faker->paragraph(2, true),
        'task_id' => rand(1, 100),
        'created_at' => $date->format('Y-m-d H:i:s')
    ];
}

$messages = [];

for ($i = 0; $i < $COUNT; $i++) {
    $messages[] = getResponse($faker);
}

return $messages;
