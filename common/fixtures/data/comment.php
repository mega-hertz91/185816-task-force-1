<?php

use Faker\Factory;
$faker = Factory::create();

$count = 400;

function getComment($faker) {
    $date = $faker->dateTimeInInterval('-1 year', '+1 year', null);
    return [
        'user_id' => rand(1, 60),
        'description' => $faker->paragraph(2, true),
        'task_id' => rand(1, 100),
        'created_at' => $date->format('Y-m-d H:i:s')
    ];
}

$comments = [];

for ($i = 0; $i < $count; $i++) {
    $comments[] = getComment($faker);
}

return $comments;
