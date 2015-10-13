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
            'max_delivery_days',
            'min_delivery_days',
            'avg_delivery_days',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
        ],
    ]) ?>

    <?php
    $dataProvider = new ActiveDataProvider([
        'query' => \app\models\Package::find()
            ->innerJoin('courier', '`courier`.`id` = `package`.`courier_id`')
            ->where([
                'courier.id' => $model->id,
            ])->orderBy('id DESC'),
        'pagination' => [
            'pageSize' => -1,
        ],
    ]);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            'description',
            'price',
            'order_date',
            'shipment_date',
            'delivery_date',
            'arrived_in',
            [
                'attribute' => 'is_disputed',
                'value'     => function ($model) {
                    $is_disputed_calc = $model->is_disputed==1?'Yes':'No';
                    return "<b style='color:darkblue;'>".$is_disputed_calc."</b>";
                },
                'format'    => 'raw'
            ],
            [
                'attribute' => 'status',
                'value'     => function ($model) {
                    return "<b style='color:red;'>".$model->status."</b>";
                },
                'format'    => 'raw'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width:70px;'],
                'header'=>'Actions',
                'template' => '{view}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = '/package/view/' . $model->id;
                        return $url;
                    }
                }
            ],
        ],
    ]);

    ?>

</div>
