<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Shipment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shipment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $allOrdersData = \app\models\Package::find()->orderBy('id')->all();
    $data = array();
    foreach ($allOrdersData as $orderData)
        $allOrderIDs[$orderData->id] = $orderData->ae_order_id.' - '.$orderData->price.' - '.$orderData->description; ?>
    <?= $form->field($model, 'order_id')->dropDownList($allOrderIDs)->label('Order ID') ?>

    <?php $allCouriers = ArrayHelper::map(\app\models\Courier::find()->orderBy('id')->all(), 'id', 'name'); ?>
    <?= $form->field($model, 'courier_id')->dropDownList($allCouriers)->label('Courier') ?>

    <?= $form->field($model, 'shipment_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($model, 'tracking_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
