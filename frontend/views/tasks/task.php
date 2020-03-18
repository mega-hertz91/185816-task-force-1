<?php
/**
 * @var \frontend\models\Task $task
 **/

use yii\helpers\Html;
use frontend\models\User;
use yii\helpers\Url;
use frontend\models\Response;

$user = User::findOne(['id' => Yii::$app->user->id]);
?>
<div style="width: 1098px; margin: auto;">
    <?php if (Yii::$app->session->getFlash('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo Yii::$app->session->getFlash('success') ?></div>
    <?php endif; ?>
    <?php if (Yii::$app->session->getFlash('error')): ?>
        <div class="alert alert-danger" role="alert"><?php echo Yii::$app->session->getFlash('error') ?></div>
    <?php endif; ?>
</div>
<div class="main-container page-container">
    <section class="content-view">
        <div class="content-view__card">
            <div class="content-view__card-wrapper">
                <div class="content-view__header">
                    <div class="content-view__headline">
                        <h1><?= Html::encode($task->title) ?></h1>
                        <span>Размещено в категории
                            <a href="#" class="link-regular"><?= Html::encode($task->category->category_name) ?></a>
                            25 минут назад
                        </span>
                    </div>
                    <b class="new-task__price new-task__price--clean content-view-price"><?= Html::encode($task->budget) ?><b> ₽</b></b>
                    <div class="new-task__icon new-task__icon--clean content-view-icon"></div>
                </div>
                <div class="content-view__description">
                    <h3 class="content-view__h3">Общее описание</h3>
                    <p>
                        <?= Html::encode($task->description) ?>
                    </p>
                </div>
                <div class="content-view__attach">
                    <h3 class="content-view__h3">Вложения</h3>
                    <a href="#">my_picture.jpeg</a>
                    <a href="#">agreement.docx</a>
                </div>
                <div class="content-view__location">
                    <h3 class="content-view__h3">Расположение</h3>
                    <div class="content-view__location-wrapper">
                        <div class="content-view__map">
                            <a href="#"><img src="../../../img/map.jpg" width="361" height="292"
                                             alt="Москва, Новый арбат, 23 к. 1"></a>
                        </div>
                        <div class="content-view__address">
                            <span class="address__town">Москва</span><br>
                            <span>Новый арбат, 23 к. 1</span>
                            <p>Вход под арку, код домофона 1122</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($user->isExecutor()): ?>
                <div class="content-view__action-buttons">
                    <?php if ($task->isDefaultStatus()): ?>
                        <button class=" button button__big-color response-button open-modal"
                                type="button" data-for="response-form">Откликнуться
                        </button>
                    <?php else : ?>
                        <button class="button button__big-color refusal-button open-modal"
                                type="button" data-for="refuse-form">Отказаться
                        </button>
                    <?php endif; ?>
                </div>
            <?php elseif ($user->isCustomer() && $task->isWorkStatus()): ?>
                <div class="content-view__action-buttons">
                    <button class="button button__big-color request-button open-modal"
                            type="button" data-for="complete-form">Завершить
                    </button>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($task->isDefaultStatus()): ?>
            <?php if (!$user->isExecutor() && $user->getId() === $task->getUserId()): ?>
                <div class="content-view__feedback">
                    <h2>Отклики <span><?= Response::getActiveCountResponses($task->id) ?></span></h2>
                    <div class="content-view__feedback-wrapper">
                        <?php foreach ($task->responses as $response) : ?>
                            <?php if ($response->isActive()): ?>
                                <div class="content-view__feedback-card">
                                    <div class="feedback-card__top">
                                        <a href="<?= Url::to(['/users/view', 'id' => $response->user->id]) ?>">
                                            <img src="../../../img/man-glasses.jpg" width="55" height="55"></a>
                                        <div class="feedback-card__top--name">
                                            <p><a href="<?= Url::to(['/users/view', 'id' => $response->user->id]) ?>"
                                                  class="link-regular"><?= Html::encode($response->user->full_name) ?></a></p>
                                            <?php for ($i = 0; $i < $user::MAX_RATING; $i++): ?>
                                                <?php if ($response->user->rating > $i): ?>
                                                    <span></span>
                                                <?php else: ?>
                                                    <span class="star-disabled"></span>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            <b><?= Html::encode($response->user->rating) ?></b>
                                        </div>
                                        <span class="new-task__time">25 минут назад</span>
                                    </div>
                                    <div class="feedback-card__content">
                                        <p>
                                            <?= Html::encode($response->message) ?>
                                        </p>
                                        <span><?= Html::encode($response->amount) ?> ₽</span>
                                    </div>
                                    <div class="feedback-card__actions">
                                        <a href="<?= Url::to(['status/work', 'id' => $task->id, 'executor' => $response->user->id]) ?>"
                                           class="button__small-color request-button button" type="button">Подтвердить</a>
                                        <a href="<?= Url::to(['status/refuse', 'id' => $response->id]) ?>" class="button__small-color refusal-button button"
                                           type="button">Отказать</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="content-view__feedback">
                    <h2>Отклики <span><?= Response::getActiveCountResponses($task->id) ?></span></h2>
                    <div class="content-view__feedback-wrapper">
                        <?php foreach ($task->responses as $response) : ?>
                            <?php if ($response->isActive()): ?>
                                <div class="content-view__feedback-card">
                                    <div class="feedback-card__top">
                                        <a href="<?= Url::to(['/users/view', 'id' => $response->user->id]) ?>"><img src="../../../img/man-glasses.jpg"
                                                                                                                    width="55" height="55"></a>
                                        <div class="feedback-card__top--name">
                                            <p><a href="<?= Url::to(['/users/view', 'id' => $response->user->id]) ?>"
                                                  class="link-regular"><?= Html::encode($response->user->full_name) ?></a></p>
                                            <?php for ($i = 0; $i < $user::MAX_RATING; $i++): ?>
                                                <?php if ($response->user->rating > $i): ?>
                                                    <span></span>
                                                <?php else: ?>
                                                    <span class="star-disabled"></span>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            <b><?= Html::encode($response->user->rating) ?></b>
                                        </div>
                                        <span class="new-task__time">25 минут назад</span>
                                    </div>
                                    <div class="feedback-card__content">
                                        <p>
                                            <?= Html::encode($response->message) ?>
                                        </p>
                                        <span><?= Html::encode($response->amount) ?> ₽</span>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__profile-mini">
            <div class="profile-mini__wrapper">
                <h3>Заказчик</h3>
                <div class="profile-mini__top">
                    <img src="../../../img/man-brune.jpg" width="62" height="62" alt="<?= Html::encode($task->user->full_name) ?>">
                    <div class="profile-mini__name five-stars__rate">
                        <p><?= Html::encode($task->user->full_name) ?></p>
                    </div>
                </div>
                <p class="info-customer">
                    <span><?= Html::encode(count($task->user->tasks)) ?> заданий</span>
                    <span class="last-">на сайте c <?= Html::encode(date('Y', strtotime($task->user->created_at))) ?> года</span></p>
                <a href="<?= Url::to(['/users/view', 'id' => $task->user->id]) ?>" class="link-regular">Смотреть профиль</a>
            </div>
        </div>
        <?php if ($user->isExecutor() || $user->getId() === $task->getUserId()): ?>
            <div class="connect-desk__chat">
                <h3>Переписка</h3>
                <div class="chat__overflow">
                    <div class="chat__message chat__message--out">
                        <p class="chat__message-time">10.05.2019, 14:56</p>
                        <p class="chat__message-text">Привет. Во сколько сможешь
                            приступить к работе?</p>
                    </div>
                    <div class="chat__message chat__message--in">
                        <p class="chat__message-time">10.05.2019, 14:57</p>
                        <p class="chat__message-text">На задание
                            выделены всего сутки, так что через час</p>
                    </div>
                    <div class="chat__message chat__message--out">
                        <p class="chat__message-time">10.05.2019, 14:57</p>
                        <p class="chat__message-text">Хорошо. Думаю, мы справимся</p>
                    </div>
                </div>
                <p class="chat__your-message">Ваше сообщение</p>
                <form class="chat__form">
                    <textarea class="input textarea textarea-chat" rows="2" name="message-text" placeholder="Текст сообщения"></textarea>
                    <button class="button chat__button" type="submit">Отправить</button>
                </form>
            </div>
        <?php endif; ?>
    </section>
</div>
<section class="modal completion-form form-modal" id="complete-form">
    <h2>Завершение задания</h2>
    <p class="form-modal-description">Задание выполнено?</p>
    <form action="#" method="post">
        <input class="visually-hidden completion-input completion-input--yes" type="radio" id="completion-radio--yes" name="completion" value="yes">
        <label class="completion-label completion-label--yes" for="completion-radio--yes">Да</label>
        <input class="visually-hidden completion-input completion-input--difficult" type="radio" id="completion-radio--yet" name="completion"
               value="difficulties">
        <label class="completion-label completion-label--difficult" for="completion-radio--yet">Возникли проблемы</label>
        <p>
            <label class="form-modal-description" for="completion-comment">Комментарий</label>
            <textarea class="input textarea" rows="4" id="completion-comment" name="completion-comment" placeholder="Place your text"></textarea>
        </p>
        <p class="form-modal-description">
            Оценка
        <div class="feedback-card__top--name completion-form-star">
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
        </div>
        </p>
        <input type="hidden" name="rating" id="rating">
        <button class="button modal-button" type="submit">Отправить</button>
    </form>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
<section class="modal form-modal refusal-form" id="refuse-form">
    <h2>Отказ от задания</h2>
    <p>
        Вы собираетесь отказаться от выполнения задания.
        Это действие приведёт к снижению вашего рейтинга.
        Вы уверены?
    </p>
    <button class="button__form-modal button" id="close-modal"
            type="button">Отмена
    </button>
    <a href="<?= \yii\helpers\Url::toRoute(['/status/failed/', 'id' => $task->id]) ?>" class="button__form-modal refusal-button button"
       type="button">Отказаться</a>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
