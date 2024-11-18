<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ["/product/update/$model->GTIN"], ['class' => 'btn btn-primary']) ?>

        <?php if($model->is_hidden):?>
        <?= Html::a('Delete', ["/product/delete/$model->GTIN"], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif?>
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
            'file_id',
            'company_id',
            'is_hidden'
        ],
    ]) ?>

</div>
