<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShipmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shipments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('New Shipment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'order_id',
                'value'     => function ($data) {
                    return $data->package->ae_order_id;
                },
                'filter' => Html::activeDropDownList($searchModel, 'order_id', ArrayHelper::map(\app\models\Package::find()->orderBy(['ae_order_id'=>SORT_ASC,])->asArray()->all(), 'id', 'ae_order_id'),['class'=>'form-control','prompt' => 'Order # ...']),
                //'format'    => 'text',

            ],
            [
                'attribute' => 'courier_id',
                'value'     => function ($data) {
                    return $data->courier->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'courier_id', ArrayHelper::map(\app\models\Courier::find()->orderBy(['name'=>SORT_ASC,])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Courier...']),
            ],
            'shipment_date',
            'tracking_id',
            // 'created_by',
            'created_at',
            // 'updated_by',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
