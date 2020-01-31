<?php

/**
 * @var array $categories frontend\models\Category
 * @var array $users frontend\models\User
 **/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\helpers\TemplateForm;

?>

<div class="main-container page-container">
    <section class="user__search">
        <div class="user__search-link">
            <p>Сортировать по:</p>
            <ul class="user__search-list">
                <li class="user__search-item user__search-item--current">
                    <a href="#" class="link-regular">Рейтингу</a>
                </li>
                <li class="user__search-item">
                    <a href="#" class="link-regular">Числу заказов</a>
                </li>
                <li class="user__search-item">
                    <a href="#" class="link-regular">Популярности</a>
                </li>
            </ul>
        </div>
        <?php foreach ($users as $user) :?>
          <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
              <div class="user__search-icon">
                <a href="#"><img src="../../../img/man-glasses.jpg" width="65" height="65" alt="unknown"></a>
                <span>17 заданий</span>
                <span>6 отзывов</span>
              </div>
              <div class="feedback-card__top--name user__search-card">
                <p class="link-name"><a href="#" class="link-regular"><?=HTML::encode($user->full_name)?></a></p>
                <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                <b>4.25</b>
                <p class="user__search-content">
                    <?=HTML::encode($user->about)?>
                </p>
              </div>
              <span class="new-task__time">Был на сайте 25 минут назад</span>
            </div>
            <div class="link-specialization user__search-link--bottom">
              <a href="#" class="link-regular">Ремонт</a>
              <a href="#" class="link-regular">Курьер</a>
              <a href="#" class="link-regular">Оператор ПК</a>
            </div>
          </div>
        <?php endforeach; ?>
    </section>
    <section class="search-task">
        <div class="search-task__wrapper">
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'search-task__form']
            ]) ?>
            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <?= html::activeCheckboxList($model, 'categories', $categories, ['item' =>
                    function ($index, $label, $name, $checked, $value) {
                        return TemplateForm::getTemplateFormCategory($label, $value, $name);
                    }]);
                ?>
            </fieldset>
            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <?= html::activeCheckboxList($model, 'additionally',
                    [
                        'free' => 'Сейчас свободен',
                        'online' => 'Сейчас онлайн',
                        'responses' => 'Есть отзывы',
                        'favorites' => 'В избранном'
                    ],
                    ['item' => function ($index, $label, $name, $checked, $value) {
                        return TemplateForm::getTemplateFormCategory($label, $value, $name);
                    }]);
                ?>
            </fieldset>
            <label class="search-task__name" for="9">Поиск по названию</label>
            <?= html::activeInput('search', $model, 'search', ['class' => 'input-middle input']) ?>
            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
            </div>
            <?php $form = ActiveForm::end() ?>
        </div>
    </section>
</div>
