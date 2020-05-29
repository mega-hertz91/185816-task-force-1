<?php

/**
 * @var common\models\Category $categories
 * @var common\models\User $users
 **/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\helpers\TemplateForm;
use yii\helpers\Url;

$this->title = 'Пользователи';
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
        <?php foreach ($users->getModels() as $user) :?>
            <?php $user = $user->user ?>
            <div class="content-view__feedback-card user__search-wrapper">
                <div class="feedback-card__top">
                    <div class="user__search-icon">
                        <a href="<?= Url::to(['users/view', 'id' => $user->id]) ?>">
                            <img src="../../../img/man-glasses.jpg" width="65" height="65" alt="unknown">
                        </a>
                        <span><?= Html::encode(count($user->tasks)) ?> заданий</span>
                        <span><?= Html::encode(count($user->comments)) ?> отзывов</span>
                    </div>
                    <div class="feedback-card__top--name user__search-card">
                        <p class="link-name">
                            <a href="<?= Url::to(['users/view', 'id' => $user->id]) ?>" class="link-regular"><?= Html::encode($user->full_name) ?></a>
                        </p>
                        <?php for ($i = 0; $i < $user::MAX_RATING; $i++): ?>
                            <?php if ($user->rating > $i): ?>
                                <span></span>
                            <?php else: ?>
                                <span class="star-disabled"></span>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <b><?=Html::encode($user->rating)?></b>
                        <p class="user__search-content">
                            <?= Html::encode($user->about) ?>
                        </p>
                    </div>
                    <span class="new-task__time">Был на сайте 25 минут назад</span>
                </div>
                <div class="link-specialization user__search-link--bottom">
                    <?php foreach ($user->categoryExecutors as $cat): ?>
                        <a href="#" class="link-regular"><?= Html::encode($cat->category->category_name) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?= yii\widgets\ListView::widget([
            'dataProvider' => $users,
            'layout' => "{pager}"
        ]); ?>
    </section>
    <section class="search-task">
        <div class="search-task__wrapper">
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'search-task__form']
            ]) ?>
            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <?= Html::activeCheckboxList($model, 'categories', $categories, ['item' =>
                    function ($index, $label, $name, $checked, $value) {
                        return TemplateForm::getTemplateFormCategory($label, $value, $name);
                    }]);
                ?>
            </fieldset>
            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <?= Html::activeCheckboxList($model, 'additionally',
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
            <?= Html::activeInput('search', $model, 'search', ['class' => 'input-middle input']) ?>
            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
            </div>
            <?php $form = ActiveForm::end() ?>
        </div>
    </section>
</div>
