<?php

$count = 40;

function getCateExecutor() {
    return [
        'user_id' => rand(1, 60),
        'category_id' =>  rand(1, 8)
    ];
}

$category_ex = [];

for ($i = 0; $i < $count; $i++) {
    $category_ex[] = getCateExecutor();
}

return $category_ex;
