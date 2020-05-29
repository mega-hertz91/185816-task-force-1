<?php

/***
 * @var User $user
 * @var UserSettingsForm $formModel
 */

use frontend\forms\UserSettingsForm;
use common\models\Category;
use common\models\City;
use common\models\User;
use yii\widgets\ActiveForm;

$this->title = 'Настройки | ' . $user->full_name;
?>

<div class="main-container page-container">
    <section class="account__redaction-wrapper">
        <h1>Редактирование настроек профиля</h1>
        <?php $form = ActiveForm::begin([
            'class' => 'settings'
        ]) ?>
        <div class="account__redaction-section">
            <h3 class="div-line">Настройки аккаунта</h3>
            <div class="account__redaction-section-wrapper">
                <div class="account__redaction-avatar">
                    <img src="../../../../img/man-glasses.jpg" width="156" height="156">
                    <input type="file" name="avatar" id="upload-avatar">
                    <label for="upload-avatar" class="link-regular">Сменить аватар</label>
                </div>
                <div class="account__redaction">
                    <div class="account__input account__input--name">
                        <?= $form->field($formModel,
                            'full_name', [
                                'inputOptions' => [
                                    'value' => $user->full_name,
                                    'class' => 'input textarea',
                                    'style' => 'display:block; width: 100%',
                                    'disabled' => 'disabled'
                                ]
                            ]
                        ) ?>
                    </div>
                    <div class="account__input account__input--email">
                        <?= $form->field($formModel,
                            'email',
                            [
                                'inputOptions' => [
                                    'value' => $user->email,
                                    'class' => 'input textarea',
                                    'style' => 'display:block; width: 100%',
                                ]
                            ]
                        ) ?>
                    </div>
                    <div class="account__input account__input--name">
                        <?= $form->field($formModel, 'city_id',
                            [
                                'inputOptions' => [
                                    'value' => $user->email,
                                    'class' => 'multiple-select input multiple-select-big',
                                    'style' => 'display:block; width: 100%',
                                ]])->dropDownList(City::find()->select('name')->indexBy('id')->column()
                        )?>
                    </div>
                    <div class="account__input account__input--date">
                        <?= $form->field($formModel,
                            'date_birth', [
                                'inputOptions' => [
                                    'value' => $user->date_birth,
                                    'class' => 'input textarea',
                                    'style' => 'display:block; width: 100%',
                                    'type' => 'date'
                                ]
                            ]
                        ) ?>
                    </div>
                    <div class="account__input account__input--info">
                        <?= $form->field($formModel,
                            'about', [
                                'inputOptions' => [
                                    'value' => $user->about,
                                    'class' => 'input textarea',
                                    'style' => 'display:block; width: 100%'
                                ]
                            ]
                        )->textarea(['rows' => 7]) ?>
                    </div>
                </div>
            </div>
            <h3 class="div-line">Выберите свои специализации</h3>
            <div class="account__redaction-section-wrapper">
                <div class="search-task__categories account_checkbox--bottom">
                    <?= $form->field($user, 'city_id',
                        [
                            'inputOptions' => [
                                'value' => $user->email,
                                'class' => 'multiple-select input multiple-select-big',
                                'style' => 'display:block; width: 100%',
                            ]])->checkboxList(Category::find()->select('category_name')->indexBy('id')->column()
                    )?>
                </div>
            </div>
            <h3 class="div-line">Безопасность</h3>
            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                    <?= $form->field($formModel,
                        'password', [
                            'inputOptions' => [
                                'value' => 'password',
                                'class' => 'input textarea',
                                'style' => 'display:block; width: 100%',
                                'type' => 'password'
                            ]
                        ]
                    ) ?>
                </div>
                <div class="account__input">
                    <?= $form->field($formModel,
                        'password_verify', [
                            'inputOptions' => [
                                'value' => 'password',
                                'class' => 'input textarea',
                                'style' => 'display:block; width: 100%',
                                'type' => 'password'
                            ]
                        ]
                    ) ?>
                </div>
            </div>
            <h3 class="div-line">Контакты</h3>
            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                    <?= $form->field(
                        $formModel,
                        'phone',
                        [
                            'inputOptions' => [
                                'class' => 'input-middle input input-date',
                                'value' => $user->phone,
                                'style' => 'display: block;',
                                'type' => 'tel'
                            ]
                        ]
                    ) ?>
                </div>
                <div class="account__input">
                    <?= $form->field(
                        $formModel,
                        'skype',
                        [
                            'inputOptions' => [
                                'class' => 'input-middle input input-date',
                                'value' => $user->skype,
                                'style' => 'display: block;',
                            ]
                        ]
                    ) ?>
                </div>
                <div class="account__input">
                    <?= $form->field(
                        $formModel,
                        'messenger',
                        [
                            'inputOptions' => [
                                'class' => 'input-middle input input-date',
                                'value' => $user->messenger,
                                'style' => 'display: block;',
                            ]
                        ]
                    ) ?>
                </div>
            </div>
            <h3 class="div-line">Настройки сайта</h3>
            <h4>Уведомления</h4>
            <div class="account__redaction-section-wrapper account_section--bottom">
                <div class="search-task__categories account_checkbox--bottom">
                    <input class="visually-hidden checkbox__input" id="216" type="checkbox" name="" value=""
                           checked>
                    <label for="216">Новое сообщение</label>
                    <input class="visually-hidden checkbox__input" id="217" type="checkbox" name="" value=""
                           checked>
                    <label for="217">Действия по заданию</label>
                    <input class="visually-hidden checkbox__input" id="218" type="checkbox" name="" value=""
                           checked>
                    <label for="218">Новый отзыв</label>
                </div>
                <div class="search-task__categories account_checkbox account_checkbox--secrecy">
                    <input class="visually-hidden checkbox__input" id="219" type="checkbox" name="" value="">
                    <label for="219">Показывать мои контакты только заказчику</label>
                    <input class="visually-hidden checkbox__input" id="220" type="checkbox" name="" value=""
                           checked>
                    <label for="220">Не показывать мой профиль</label>
                </div>
            </div>
        </div>
        <button class="button" type="submit">Сохранить изменения</button>
        <?php $form::end() ?>
    </section>
</div>
