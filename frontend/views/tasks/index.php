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
        <section class="new-task">
            <div class="new-task__wrapper">
                <?php if (empty($tasks)) : ?>
                    <h1><?= 'Задания не найдены' ?></h1>
                <?php else: ?>
                    <h1>Новые задания</h1>
                <?php endif ?>
                <?php foreach ($tasks as $task) : ?>
                    <div class="new-task__card">
                        <div class="new-task__title">
                            <a href="#" class="link-regular">
                                <h2><?= HTML::encode($task->title) ?></h2>
                            </a>
                            <a class="new-task__type link-regular" href="#"><p><?= HTML::encode($task->category['category_name']) ?></p></a>
                        </div>
                        <div class="new-task__icon new-task__icon--translation"></div>
                        <p class="new-task_description">
                            <?= HTML::encode($task->description) ?>
                        </p>
                        <b class="new-task__price new-task__price--translation"><?= HTML::encode($task->amount) ?><b> ₽</b></b>
                        <p class="new-task__place"><?= HTML::encode($task->city['name']) ?></p>
                        <span class="new-task__time"><?= HTML::encode(Yii::$app->formatter->asDate($task->created_at)) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
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
                        ['response' => 'Без откликов', 'telework' => 'Удаленная работа'],
                        ['item' => function ($index, $label, $name, $checked, $value) {
                            return TemplateForm::getTemplateFormCategory($label, $value, $name);
                        }]);
                    ?>
                </fieldset>
                <label class="search-task__name" for="8">Период</label>
                <?php echo html::activeDropDownList($model, 'period', [
                    'all' => 'За все время',
                    'day' => 'За день',
                    'week' => 'За неделю',
                    'month' => 'За менсяц'], ['class' => 'multiple-select input']);
                ?>
                <label class="search-task__name" for="9">Поиск по названию</label>
                <?= html::activeInput('search', $model, 'search', ['class' => 'input-middle input']) ?>
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
                <?php $form = ActiveForm::end() ?>
            </div>
        </section>
    </div>
<?php var_dump($result);
