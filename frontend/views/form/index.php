<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'options' => ['class' => 'search-task__form']
]) ?>
<?php $form->field($model, 'translation')->checkbox()->label('перевод') ?>
<?php $form->field($model, 'clean')->checkbox() ?>
<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
</div>
<?php $form = ActiveForm::end() ?>
<p><?php
    echo "<pre>";
    print_r($result['TasksForm']) ?></p>
