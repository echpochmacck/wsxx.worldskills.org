<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['new'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'name',
            'french_name',
            'GTIN',
            'description:ntext',

            [

                'label' => 'View',
                'value' => fn ($model) => Html::a('view',["/product/$model->GTIN"], ['class' => 'btn btn-success']),
                'format' => 'html'
            ],
            'is_hidden'
            //'french_description:ntext',
            //'brand',
            //'country',
            //'weight',
            //'unit_weight',
            //'gross_weight',
            //'file_id',
            //'company_id',
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Product $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //      }
            // ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
