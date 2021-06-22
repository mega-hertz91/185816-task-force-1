<?php

use Faker\Factory;

$faker = Factory::create('ru_RU');
$count = 20;

function getMessage($faker) {
    $date = $faker->dateTimeInInterval('-1 year', '+1 year', null);
    return [
        'sender' => 1,
        'recipient' => 2,
        'message' => $faker->paragraph(2, true),
        'task_id' => rand(1, 5),
        'created_at' => $date->format('Y-m-d H:i:s')
    ];
}

$messages = [];

for ($i = 0; $i < $count; $i++) {
    $messages[] = getMessage($faker);
}

return $messages;
