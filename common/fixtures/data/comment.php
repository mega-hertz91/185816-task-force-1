<?php

use Faker\Factory;

$faker = Factory::create('en_US');
$count = 10;

function getComment($faker) {
    $date = $faker->dateTimeInInterval('-1 year', '+1 year', null);
    return [
        'user_id' => rand(1, 2),
        'task_id' => rand(1, 5),
        'description' => $faker->paragraph(2, true),
        'executor_id' => 2,
        'rating' => rand(1, 5),
        'created_at' => $date->format('Y-m-d H:i:s')
    ];
}

$comments = [];

for ($i = 0; $i < $count; $i++) {
    $comments[] = getComment($faker);
}

return $comments;
