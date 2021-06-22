<?php

/* @var View $this
 * @var Notice $notice
 * @var string $content
 */

/***
 * @var common\models\Task $task
 */

use common\models\Notice;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<div class="table-layout">
    <?php $this->beginBody() ?>
    <?= $this->render('components/header-main') ?>
    <main class="page-main">
        <?= $content ?>
    </main>
    <?= $this->render('components/footer')?>
</div>
<div class="overlay"></div>
<script>
    var popup = document.querySelector('.lightbulb__pop-up');
    var links = popup.querySelectorAll('.link-notice');
    var items = popup.querySelectorAll('.lightbulb__new-task');

    popup.addEventListener('click', function (e) {
        e.preventDefault();

        for (var i = 0; i < links.length; i++) {
            if (links[i] === e.target) {
                const currentElement = links[i];
                const currentItem = items[i];
                const result = fetch(currentElement.getAttribute('href'), {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    }
                });

                result.then(function (response) {
                   if(response.status === 200) {
                       currentItem.remove();
                       if(currentElement.getAttribute('data-to')) {
                           location.href = currentElement.getAttribute('data-to');
                       }
                   }
                });
            }
        }
    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
