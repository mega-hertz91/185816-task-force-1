<?php

use Faker\Factory;
$faker = Factory::create();

$count = 600;

function getMessage($faker) {
    $date = $faker->dateTimeInInterval('-1 year', '+1 year', null);
    return [
        'sender' => rand(1, 200),
        'recipient' => rand(1, 200),
        'message' => $faker->paragraph(2, true),
        'task_id' => rand(1, 100),
        'created_at' => $date->format('Y-m-d H:i:s')
    ];
}

$messages = [];

for ($i = 0; $i < $count; $i++) {
    $messages[] = getMessage($faker);
}

return $messages;
