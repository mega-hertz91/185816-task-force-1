<?php

/**
 * @var $form yii\widgets\ActiveForm
 * @var $model frontend\forms\CreateTask
 * @var $categories frontend\models\Category
 */

use yii\widgets\ActiveForm;
use frontend\models\Category;

$this->title = 'Публикация нового задания';

?>

<div class="main-container page-container">
    <section class="create__task">
        <h1>Публикация нового задания</h1>
        <div class="create__task-main">
            <?php
            $form = ActiveForm::begin(['options' => [
                'class' => 'create__task-form form-create',
                'enctype' => 'multipart/form-data'
            ]])
            ?>
            <?= $form->field($model, 'title',
                [
                    'inputOptions' => ['class' => 'input textarea', 'placeholder' => 'Повесить полку', 'style' => 'display: block; width: 100%']
                ]
            ) ?>
            <span>Кратко опишите суть работы</span>
            <?= $form->field($model, 'description',
                [
                    'inputOptions' => ['class' => 'input textarea', 'placeholder' => 'Введите текст', 'style' => 'display: block; width: 100%']
                ]
            )->textarea(['rows' => 7, 'cols' => 5]) ?>
            <span>Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться</span>
            <?= $form->field($model, 'category',
                [
                    'inputOptions' => ['class' => 'multiple-select input multiple-select-big', 'placeholder' => 'Введите текст', 'style' => 'display: block; width: 100%']
                ]
            )->dropDownList(Category::find()->select(['category_name', 'id'])->indexBy('id')->column()) ?>
            <span>Выберите категорию</span>
            <label>Файлы</label>
            <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
            <div class="create__file">
                <span>Добавить новый файл</span>
                <!--                          <input type="file" name="files[]" class="dropzone">-->
            </div>
            <label for="13">Локация</label>
            <input class="input-navigation input-middle input" id="13" type="search" name="q" placeholder="Санкт-Петербург, Калининский район">
            <span>Укажите адрес исполнения, если задание требует присутствия</span>
            <div class="create__price-time">
                <div class="create__price-time--wrapper">
                    <?= $form->field($model, 'budget',
                        [
                            'inputOptions' => ['class' => 'input textarea input-money', 'placeholder' => 'Бюджет', 'style' => 'display: block;']
                        ]
                    ) ?>
                    <span>Не заполняйте для оценки исполнителем</span>
                </div>
                <div class="create__price-time--wrapper">
                    <?= $form->field($model, 'deadline',
                        [
                            'inputOptions' => ['class' => 'input-middle input input-date', 'placeholder' => '10.11, 15:00', 'style' => 'display: block;', 'type' =>'date']
                        ]
                    ) ?>
                    <span>Укажите крайний срок исполнения</span>
                </div>
            </div>
            <?php
            ActiveForm::end()
            ?>
            <div class="create__warnings">
                <div class="warning-item warning-item--advice">
                    <h2>Правила хорошего описания</h2>
                    <h3>Подробности</h3>
                    <p>Друзья, не используйте случайный<br>
                        контент – ни наш, ни чей-либо еще. Заполняйте свои
                        макеты, вайрфреймы, мокапы и прототипы реальным
                        содержимым.</p>
                    <h3>Файлы</h3>
                    <p>Если загружаете фотографии объекта, то убедитесь,
                        что всё в фокусе, а фото показывает объект со всех
                        ракурсов.</p>
                </div>
                <div class="warning-item warning-item--error">
                    <h2>Ошибки заполнения формы</h2>
                    <h3>Категория</h3>
                    <p>Это поле должно быть выбрано.<br>
                        Задание должно принадлежать одной из категорий</p>
                </div>
            </div>
        </div>
        <button form="task-form" class="button" type="submit">Опубликовать</button>
    </section>
</div>
