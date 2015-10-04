<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Courier */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Couriers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courier-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'name',
            'url:url',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
        ],
    ]) ?>

    <?php
    $dataProvider = new ActiveDataProvider([
        'query' => \app\models\Shipment::find()
            ->innerJoin('package', '`shipment`.`order_id` = `package`.`id`')
            ->where([
                'shipment.courier_id' => $model->id,
                'package.delivery_date' => "0000-00-00",
            ])->with('package'),
        'pagination' => [
            'pageSize' => -1,
        ],
    ]);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'package.ae_order_id',
            'shipment_date',
            'tracking_id',
            'package.delivery_date',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
