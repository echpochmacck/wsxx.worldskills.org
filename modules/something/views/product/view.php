<?php

use app\models\File;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['/something/product/']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ["/something/product/update/$model->GTIN"], ['class' => 'btn btn-primary']) ?>

        <?php if ($model->is_hidden): ?>
            <?= Html::a('Delete', ["/something/product/delete/$model->GTIN"], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php else: ?>

            <?= Html::a('Hide', ["/something/product/hide/$model->GTIN"], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to hide this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'french_name',
            'GTIN',
            'description:ntext',
            'french_description:ntext',
            'brand',
            'country',
            'weight',
            'unit_weight',
            'gross_weight',
            'company_id',
            'is_hidden',

            [
                'label' => 'IMG',
                'value' => function ($model) {

                    if ($file = File::findOne(['product_id' => $model->id])) {
                        return  Html::img("/src/$file->name", ['width' => '300px', 'height' => '200px']);
                    } else {
                        return  Html::img("/src/placeholder.jpg", ['width' => '300px', 'height' => '200px']);;
                    }
                },
                'format' => 'html',
            ],
            [
                
                'label' => 'Удалить фото',
                'value' => fn($model) => Html::a('удалить', ["/something/product/file/$model->GTIN"], ['class' => 'btn btn-success']),
                'format' => 'html',
            ],
        ],
    ]) ?>

</div>