<?php

use app\models\File as ModelsFile;
use app\models\Product;
use PharIo\Manifest\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url as HelpersUrl;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\company $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['/something/company']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="company-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($model->isActivate):?>
    <p>
        <?= Html::a('Deactivate', ['/something/company/deactivate/', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif ?>

        
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'company_name',
            'company_address',
            'company_telephone_number',
            'company_email_address:email',
            'owner_id',
            'isActivate',

        ],
    ]) ?>


    <h2>Products</h2>
    <?= GridView::widget([
        'dataProvider' => $products,
        'columns' => [

            'id',
            'name',
            'french_name',
            'GTIN',
            'description',
            'french_description',
            'brand',
            'country',
            'weight',
            'unit_weight',

            [
                'label' => 'IMG',
                'value' => function ($model) {

                    if ($file = ModelsFile::findOne(['product_id' => $model->id])) {
                        return  Html::img("/src/$file->name", ['width' => '300px', 'height' => '200px']);
                    } else {
                        return 'adasd';
                    }
                },
                'format' => 'html',
            ],

            [

                'label' => 'View',
                'value' => fn($model) => Html::a('Vie', ["/something/product/$model->GTIN"], ['class' => 'btn btn-danger']),
                'format' => 'html'
            ],



        ],
    ]); ?>

</div>