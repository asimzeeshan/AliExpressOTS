<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Packages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('New Package', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            // 'id',
            [
                'attribute' => 'store_id',
                'value'     => function ($data) {
                    return $data->store->name;
                },
                //'options' => array('width' => 200),
                'filter' => Html::activeDropDownList($searchModel, 'store_id', ArrayHelper::map(\app\models\Store::find()->orderBy(['name'=>SORT_ASC,])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Store ...']),
            ],
            [
                'attribute' => 'order_id',
                'options' => array('width' => 150),
            ],
            [
                'attribute' => 'price',
                'options' => array('width' => 60),
            ],
            [
                'attribute' => 'order_date',
                'options' => array('width' => 100),
            ],
            [
                'attribute' => 'paid_with',
                'value'     => function ($data) {
                    return $data->paymentMethod->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'paid_with', ArrayHelper::map(\app\models\PaymentMethod::find()->orderBy(['name'=>SORT_ASC,])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Select...']),
                'options' => array('width' => 140),
            ],
            'description',
            // 'courier_id',
            // 'tracking_id',
            // 'shipment_date',
            // 'delivery_date',
            // 'arrived_in',
            // 'is_disputed',
            // 'refund_status',
            [
                'attribute' => 'status',
                'value'     => function ($data) {
                    return "<b style='color:red;'>".$data->status."</b>";
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', ArrayHelper::map(\app\models\Package::find()->orderBy(['status'=>SORT_ASC,])->addGroupBy(['status'])->asArray()->all(), 'status', 'status'),['class'=>'form-control','prompt' => 'Select...']),
                'options' => array('width' => 160),
                'format'    => 'raw'
            ],
            // 'notes:ntext',
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',
            [
                'label'   => 'Details',
                'format' => 'raw',
                'value'   => function ($data) {
                    if ($data->is_disputed==1) {
                        return "Disputed";
                    } else if ($data->is_disputed!=1 && $data->shipment_date=="0000-00-00") {
                        return "Shipping...";
                    } else if ($data->is_disputed!=1 && $data->delivery_date<>"0000-00-00" && $data->shipment_date<>"0000-00-00") {
                        return "Received on ".$data->delivery_date;
                    } else if ($data->is_disputed!=1 && $data->delivery_date=="0000-00-00" && $data->shipment_date<>"0000-00-00") {
                        return "En route since ".\app\models\Package::getDaysElapsed($data->shipment_date);
                    } else {
                        return "Unknown!";
                    }
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width:120px;'],
                'template' => '{view} {shipped} {received} {update} {delete}',
                'buttons' => [
                    'shipped' => function ($url, $model) {
                        if ($model->shipment_date=="0000-00-00") {
                            $shippedButtonClass = "glyphicon-unchecked";
                            $shippedButtonTitle = "Mark item as shipped?";
                        } else {
                            $shippedButtonClass = "glyphicon-check";
                            $shippedButtonTitle = "Mistake? Mark item not shipped";
                        }

                        return Html::a('<span class="glyphicon '.$shippedButtonClass.'"></span>', $url, [
                            'title' => Yii::t('yii', $shippedButtonTitle),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to mark this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                    'received' => function ($url, $model) {
                        if ($model->delivery_date=="0000-00-00" && $model->shipment_date=="0000-00-00") {
                            $receivedButtonClass = "glyphicon-ban-circle";
                            $receivedButtonTitle = "Not yet shipped";
                        } else if ($model->delivery_date=="0000-00-00" && $model->shipment_date<>"0000-00-00") {
                            $receivedButtonClass = "glyphicon-heart-empty";
                            $receivedButtonTitle = "Mark item received";
                        } else {
                            $receivedButtonClass = "glyphicon-heart";
                            $receivedButtonTitle = "Mistake? Mark item not received";
                        }

                        return Html::a('<span class="glyphicon '.$receivedButtonClass.'"></span>', $url, [
                            'title' => Yii::t('yii', $receivedButtonTitle),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to mark this item? WARNING: If the item is already marked, it will unmark it!'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
