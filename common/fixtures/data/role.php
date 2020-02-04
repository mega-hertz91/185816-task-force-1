<?php

return [
    [
        'role' => 'admin',
        'actions' => 'work, complete, failed, cancel, public'
    ],
    [
        'role' => 'customer',
        'actions' => 'work, cancel, public'
    ],
    [
        'role' => 'executor',
        'actions' => 'failed, complete'
    ],
];
