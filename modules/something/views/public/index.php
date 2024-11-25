<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var ActiveForm $form */
?>
<div class="public-index">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'gtin_arr')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- public-index -->


<?php if (!empty($arr)): ?>

    <?php if ($arr->getCount() == $count): ?>
        <h1>

        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
        </svg>
        </h1>

    <?php endif ?>

    <div class="box">
        <?php
        echo GridView::widget([
            'dataProvider' => $arr,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'], // Сериализация строк
                'GTIN', // Колонка id
                'status', // Колонка name
            ],
        ]);
        ?>
    </div>

<?php endif ?>