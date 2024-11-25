<?php

use app\models\File;
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
    <p>
        <?= Html::a('ENG', "/01/$model->GTIN", ['class' => 'btn btn-success']) ?>
        <?= Html::a('FR', ["/01/$model->GTIN", 'ln' => 'fr'], ['class' => 'btn btn-success']) ?>

    </p>

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'name',
                'value' => Yii::$app->request->get('ln') ? $model->french_name : $model->name,
            ],
            'GTIN',
            [
                'label' => 'description',
                'value' => Yii::$app->request->get('ln') ? $model->french_description : $model->description,
            ],
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
                        return  Html::img("/src/$file->name", [
                            'alt' => '',
                            'width' => '300px',
                            'height' => '200px',
                            'onerror' => "this.onerror=null; this.src='/src/placeholder.jpg';"
                        ]);
                    } else {

                        return Html::img("/src/placeholder.jpg", [
                            'alt' => 'Наш логотип',
                            'width' => '300px',
                            'height' => '200px',
                            'onerror' => "this.onerror=null; this.src='/src/placeholder.jp';"
                        ]);
                    }
                },
                'format' => 'html',
            ],
            // [
            //     'label' => 'Удалить фото',
            //     'value' => fn($model) => Html::a('удалить', ["/product/file/$model->GTIN"], ['class' => 'btn btn-success']),
            //     'format' => 'html',
            // ],
        ],
    ]) ?>

</div>