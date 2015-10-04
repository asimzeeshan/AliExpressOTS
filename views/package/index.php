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
                'attribute' => 'ae_order_id',
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
            // 'delivery_date',
            // 'arrived_in',
            // 'is_disputed',
            // 'refund_status',
            // 'notes:ntext',
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',
            [
                'label'   => 'status',
                'format' => 'raw',
                'value'   => function ($data) {
                    if ($data->is_disputed==1) {
                        return "Disputed";
                    } else if ($data->delivery_date<>"0000-00-00") {
                        return "Received on ".$data->delivery_date;
                    } else if ($data->delivery_date=="0000-00-00" && \app\models\Shipment::isShipped($data->id)==true) {
                        return "En route since ".\app\models\Package::getDaysElapsed($data->id);
                    } else {
                        return "Shipping...";
                    }
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
