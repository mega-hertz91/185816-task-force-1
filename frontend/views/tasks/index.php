<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

?>
<div class="main-container page-container">
  <section class="new-task">
    <div class="new-task__wrapper">
      <h1>Новые задания</h1>
      <?php foreach ($tasks as $task) :?>
        <div class="new-task__card">
          <div class="new-task__title">
            <a href="#" class="link-regular">
              <h2><?=HTML::encode($task->title)?></h2>
            </a>
            <a class="new-task__type link-regular" href="#"><p><?=HTML::encode($task->category['category_name'])?></p></a>
          </div>
          <div class="new-task__icon new-task__icon--translation"></div>
          <p class="new-task_description">
              <?=HTML::encode($task->description)?>
          </p>
          <b class="new-task__price new-task__price--translation"><?=HTML::encode($task->amount)?><b> ₽</b></b>
          <p class="new-task__place"><?=HTML::encode($task->city['name'])?></p>
          <span class="new-task__time"><?=HTML::encode($task->created_at)?></span>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="new-task__pagination">
        <ul class="new-task__pagination-list">
            <li class="pagination__item"><a href="#"></a></li>
            <li class="pagination__item pagination__item--current">
                <a>1</a></li>
            <li class="pagination__item"><a href="#">2</a></li>
            <li class="pagination__item"><a href="#">3</a></li>
            <li class="pagination__item"><a href="#"></a></li>
        </ul>
    </div>
  </section>
    <section class="search-task">
        <div class="search-task__wrapper">
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'search-task__form']
            ]) ?>
            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <?php
                echo $form->field($model, 'categories')
                    ->checkboxList($model->attributeLabels())
                    ->label(false);
                ?>
            </fieldset>
            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <?php
                echo $form->field($model, 'additionally')->checkboxList([
                    'no response' => 'Без откликов',
                    'telework' => 'Удаленная работа'
                ])->label(false);
                ?>
            </fieldset>
            <?php echo $form->field($model, 'period')
                ->dropDownList([
                    'day' => 'За день',
                    'week' => 'За неделю',
                    'month' => 'За менсяц'],
                    ['class' => 'multiple-select input']
                )->label('Период', ['class' => 'search-task__name']);
            ?>
            <?php echo $form->field($model, 'search')
                ->textInput()
                ->label('Поиск по названию', ['class' => 'search-task__name']);
            ?>
            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
            </div>
            <?php $form = ActiveForm::end() ?>
        </div>
    </section>
</div>
<p><?php
    echo "<pre>";
    foreach ($result as $item) {
        var_dump($item);
    };

   //print_r($result);
    ?>
</p>
