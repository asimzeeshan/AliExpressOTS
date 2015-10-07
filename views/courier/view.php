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
            'package.description',
            'shipment_date',
            'tracking_id',
            'package.delivery_date',

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width:70px;'],
                'header'=>'Actions',
                'template' => '{view}',
//                'buttons' => [
//
//                    //view button
//                    'view' => function ($url, $model) {
//                        return Html::a('<span class="fa fa-search"></span>View', $url, [
//                            'title' => Yii::t('app', 'View'),
//                            'class'=>'btn btn-primary btn-xs',
//                        ]);
//                    },
//                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = '/package/view/' . $model->id;
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>

</div>
