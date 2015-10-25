<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Store */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-view">

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
        <?= Html::a('Import Store', ['import'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'store_number',
            'name',
            'location',
            'since',
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

    <?php
    $dataProvider = new ActiveDataProvider([
        'query' => \app\models\Package::find()
            ->innerJoin('store', '`store`.`id` = `package`.`store_id`')
            ->where([
                'store.id' => $model->id,
            ])->with('store')->orderBy('id DESC'),
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
            'is_disputed',
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
