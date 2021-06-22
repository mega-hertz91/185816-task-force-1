<?php

/***
 * @var object $content frontend\View\site\create.php
 */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\widgets\ActiveForm;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="landing">
<div class="table-layout">
    <?php $this->beginBody() ?>
    <?= $this->render('components/header-landing') ?>
    <main>
        <?= $content ?>
    </main>
    <?= $this->render('components/footer') ?>
    <section class="modal enter-form form-modal" id="enter-form" style="bottom: auto">
        <h2>Вход на сайт</h2>
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['login/index'])
        ])?>
        <?=$form->field($this->context->model, 'email',
            [
                'inputOptions' => ['class' => 'input textarea', 'placeholder' => 'kumarm@mail.ru', 'style' => 'width: 100%']
            ]
        ) ?>
        <?=$form->field($this->context->model, 'password',
            [
                'inputOptions' => ['class' => 'input textarea', 'style' => 'width: 100%', 'type' => 'password']
            ]
        ) ?>
        <button class="button button__registration" type="submit">Войти</button>
        <?php ActiveForm::end()?>
        <button class="form-modal-close" type="button">Закрыть</button>
        <?= yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['site/auth'],
            'popupMode' => false,
        ]) ?>
    </section>
</div>
<div class="overlay"></div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
