<?php

use yii\helpers\Html;

use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Package */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('New', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Import Package', ['import'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'store_id',
                'value'     => empty($model->store_id)?"<i>N/A</i>":"<b>".$model->store->name."</b>",
                'format'    => 'raw'
            ],
            [
                'attribute' => 'order_id',
                'value'     => $model->order_id." [".Html::a('AliExpress Order Page','http://trade.aliexpress.com/order_detail.htm?orderId='.$model->order_id, array('target'=>'_blank'))."]",
                'format'    => 'raw'
            ],
            'price',
            'order_date',
            [
                'attribute' => 'description',
                'value'     => "<b>".$model->description."</b>",
                'format'    => 'raw'
            ],
            [
                'attribute' => 'courier_id',
                'value'     => $model->courier_id?$model->courier->name:"N/A",
                'format'    => 'text',
            ],
            [
                'attribute' => 'tracking_id',
                'value'     => $model->tracking_id!=''?$model->tracking_id." [".Html::a('17track','http://www.17track.net/en/result/post-details.shtml?nums='.$model->tracking_id, array('target'=>'_blank'))." / ".Html::a('ep.gov.pk','http://ep.gov.pk/track/eptrackdirect.aspx?id='.$model->tracking_id, array('target'=>'_blank'))."]":"",
                'format'    => 'raw'
            ],
            [
                'attribute' => 'shipment_date',
                'value'     => $model->shipment_date=="0000-00-00"?"":$model->shipment_date,
                'format'    => 'raw'
            ],
            [
                'attribute' => 'delivery_date',
                'value'     => $model->is_disputed==1?"N/A":($model->delivery_date=="0000-00-00"?"Waiting...":$model->delivery_date),
                'format'    => 'text'
            ],
            [
                'attribute' => 'arrived_in',
                'value'     => $model->arrived_in?"<b style='color: #0000ff;'>".$model->arrived_in." days</b>":"N/A",
                'format'    => 'raw'
            ],
            [
                'attribute' => 'paid_with',
                'value'     => $model->paymentMethod->name,
                'format'    => 'text'
            ],
            [
                'attribute' => 'is_disputed',
                'value'     => $model->is_disputed==1?"Yes":"No",
                'format'    => 'text'
            ],
            [
                'attribute' => 'refund_status',
                'value'     => $model->is_disputed==1?$model->refund_status:"N/A",
                'format'    => 'text'
            ],
            [
                'attribute' => 'status',
                'value'     => "<b style='color:red;'>".$model->status."</b>",
                'format'    => 'raw'
            ],
            'notes:ntext',
            [
                'attribute' => 'created_by',
                'value'     => $model->createdByUser->username,
                'format'    => 'text'
            ],
            'created_at',
            [
                'attribute' => 'updated_by',
                'value'     => $model->updatedByUser->username,
                'format'    => 'text'
            ],
            'updated_at',
        ],
    ]) ?>

</div>
