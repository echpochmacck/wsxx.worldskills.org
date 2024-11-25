<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'My Yii Application';
?>
<?php if (!Yii::$app->user->isGuest): ?>
    <div class="site-index">

        <?= Html::a('companyes', "/something/company/", ['class' => 'btn btn-success']) ?>
        <div class="my-2"><?= Html::a('products', "/something/product/", ['class' => 'btn btn-success my-2']) ?></div>
    </div>
<?php else: ?>
    <?= Html::a('CheckGtin', "/something/public/", ['class' => 'btn btn-success']) ?>

<?php endif ?>