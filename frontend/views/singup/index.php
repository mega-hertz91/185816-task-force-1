<?php

/**
 * @var \yii\base\Model $form \frontend\forms\SingupForm
 * @var array $errors \frontend\forms\SingupForm
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="main-container page-container">
    <section class="registration__user">
        <h1>Регистрация аккаунта</h1>
        <?php echo Yii::$app->session->getFlash('reg') ?>
        <div class="registration-wrapper">
            <?php ActiveForm::begin(['options' => [
                'class'=> 'registration__user-form form-create'
            ]])?>
            <label for="singupform-email" class="<?php if(!empty($errors['email'])) {echo 'input-danger';}?>">Электронная почта</label>
            <?=html::activeInput('email', $form, 'email', ['class' => 'input textarea', 'placeholder' => 'kumarm@mail.ru'])?>
            <span><?php if(!empty($errors['email'])) {echo $errors['email'][0];}?></span>
            <label for="singupform-name" class="<?php if(!empty($errors['name'])) {echo 'input-danger';}?>">Ваше имя</label>
            <?=html::activeInput('text', $form, 'name', ['class' => 'input textarea', 'placeholder' => 'Мамедов Кумар'])?>
            <span><?php if(!empty($errors['name'])) {echo $errors['name'][0];}?></span>
            <label for="singupform-city">Город проживания</label>
            <?=html::activeDropDownList($form, 'city', $cities, ['class' => 'multiple-select input town-select registration-town']); ?>
            <span>Укажите город, чтобы находить подходящие задачи</span>
            <label class="<?php if(!empty($errors['password'])) {echo 'input-danger';}?>" for="singupform-password">Пароль</label>
            <?=html::activeInput('password', $form, 'password', ['class' => 'input textarea'])?>
            <span><?php if(!empty($errors['password'])) {echo $errors['password'][0];}?></span>
            <button class="button button__registration" type="submit">Cоздать аккаунт</button>
            <?php ActiveForm::end()?>
        </div>
    </section>
</div>
