<?php

use Faker\Factory;
$faker = Factory::create();

$count = 50;

function getResponse($faker) {
    $faker = Factory::create();
    $date = $faker->dateTimeInInterval('-1 year', '+1 year', null);
    return [
        'user_id' => rand(1, 60),
        'amount' => rand(1000, 200000),
        'message' => $faker->paragraph(2, true),
        'task_id' => rand(1, 10),
        'created_at' => $date->format('Y-m-d H:i:s')
    ];
}

$messages = [];

for ($i = 0; $i < $count; $i++) {
    $messages[] = getResponse($faker);
}

return $messages;
