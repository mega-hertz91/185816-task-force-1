<?php

use yii\widgets\Menu;

?>

<div class="header__nav">
    <?= Menu::widget([
        'options' => ['class' => 'header-nav__list site-list'],
        'itemOptions' => ['class' => 'site-list__item'],
        'items' => [
            ['label' => 'Задания', 'url' => ['tasks/']],
            ['label' => 'Исполнители', 'url' => ['users/']],
            ['label' => 'Создать задание', 'url' => ['task/create']],
            ['label' => 'Мой профиль', 'url' => ['cabinet/settings']]
        ],
    ]);
    ?>
</div>
