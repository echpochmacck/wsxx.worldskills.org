<?php

use app\models\Product;
use Faker\Core\File;
use PharIo\Manifest\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url as HelpersUrl;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\company $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="company-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Deactivate', ['deactivate', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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

                'label' => 'File',
                'value' => fn () => Html::img('/upoads/' . 'dsd',['alt' => 'Изображенеи отсуствует']),
                'format' => 'html'
            ],

            [

                'label' => 'View',
                'value' => fn ($model) => Html::a('Vie',["/view/$model->GTIN"], ['class' => 'btn btn-danger']),
                'format' => 'html'
            ],

            
            
        ],
    ]); ?>

</div>
