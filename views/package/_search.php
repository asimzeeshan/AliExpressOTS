<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\PackageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="package-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php $allStores = ArrayHelper::map(\app\models\Store::find()->orderBy('name')->all(), 'id', 'name'); ?>
    <?= $form->field($model, 'store_id')->dropDownList($allStores,['prompt' => ' -- Select Store --'])->label('Store') ?>

    <?= $form->field($model, 'order_id') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'order_date') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'courier_id') ?>

    <?= $form->field($model, 'tracking_id') ?>

    <?php // echo $form->field($model, 'shipment_date') ?>

    <?php // echo $form->field($model, 'delivery_date') ?>

    <?php // echo $form->field($model, 'arrived_in') ?>

    <?php // echo $form->field($model, 'paid_with') ?>

    <?php // echo $form->field($model, 'is_disputed') ?>

    <?php // echo $form->field($model, 'refund_status') ?>

    <?php // echo $form->field($model, 'notes') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
