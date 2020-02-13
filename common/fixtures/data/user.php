<?php

use Faker\Factory;
$faker = Factory::create();

$count = 60;

function getUsers($faker) {
    $date = $faker->dateTimeInInterval('-1 year', '+1 year', null);
    return [
        'full_name' => $faker->name,
        'email' => $faker->email,
        'role_id' => rand(1, 3),
        'city_id' => rand(1, 100),
        'user_status_id' => rand(1, 3),
        'date_birth' => $faker->date('Y-m-d', '2000-01-01'),
        'about' => $faker->text(300),
        'password' => '$2y$13$sPwhAm3eobdmK5Z.oT/LS.fxCN1seTr3qxzz0qXuCHub85HreDl3a',
        'phone' => $faker->tollFreePhoneNumber,
        'skype' => $faker->userName,
        'messenger' => $faker->domainWord,
        'created_at' => $date->format('Y-m-d H:i:s')
    ];
}

$users = [];

for ($i = 0; $i < $count; $i++) {
    $users[] = getUsers($faker);
}

return $users;
