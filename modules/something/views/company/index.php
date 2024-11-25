<?php

use app\models\company;
use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

use function PHPSTORM_META\map;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Companies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Company', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'company_name',
            'isActivate',
            'company_address',
            'company_telephone_number',
            'company_email_address:email',
            //'owner_id',
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, company $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //     }
            // ],
            [
                'label' => 'Просмотреть',
                'value' => fn($model) => Html::a('view', ['view', 'id' => $model->id], ['class' => 'btn btn-success']),
                'format' => 'html'
            ]
        ],
    ]); ?>




    <?php Pjax::end(); ?>

</div>