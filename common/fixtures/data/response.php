<?php

use Faker\Factory;
$faker = Factory::create('ru_RU');
$count = 2;

function getResponse($faker) {
    $date = $faker->dateTimeInInterval('-1 year', '+1 year', null);
    return [
        'user_id' => 1,
        'amount' => rand(1000, 200000),
        'message' => $faker->paragraph(2, true),
        'task_id' => rand(1, 5),
        'created_at' => $date->format('Y-m-d H:i:s')
    ];
}

$messages = [];

for ($i = 0; $i < $count; $i++) {
    $messages[] = getResponse($faker);
}

return $messages;
