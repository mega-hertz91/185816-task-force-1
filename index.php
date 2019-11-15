<?php

require_once __DIR__ . '/vendor/autoload.php';

use Services\NewAction;

$target = new NewAction();

print($target::NAME);
