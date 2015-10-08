<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Package */
/* @var $form yii\widgets\ActiveForm */

$judgar = "";
if ($model->shipment_date=="0000-00-00")
    $judgar .= '$("#package-shipment_date").val("");';
if ($model->delivery_date=="0000-00-00")
    $judgar .= '$("#package-delivery_date").val("");';

$this->registerJs($judgar);
?>

<div class="package-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $allStores = ArrayHelper::map(\app\models\Store::find()->orderBy('name')->all(), 'id', 'name'); ?>
    <?= $form->field($model, 'store_id')->dropDownList($allStores,['prompt' => ' -- Select Store --'])->label('Store') ?>

    <?php
//    $allStoresData = \app\models\Store::find()->orderBy('store_number')->all();
//    $data = array();
//    foreach ($allStoresData as $storeData)
//        $allStoreIDs[$storeData->id] = $storeData->store_number.' - '.$storeData->name;
//    echo $form->field($model, 'store_id')->dropDownList($allStoreIDs)->label('Store');
    ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php $allCouriers = ArrayHelper::map(\app\models\Courier::find()->orderBy('id')->all(), 'id', 'name'); ?>
    <?= $form->field($model, 'courier_id')->dropDownList($allCouriers,['prompt' => ' -- Select Courier --'])->label('Courier') ?>

    <?= $form->field($model, 'tracking_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipment_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?php if ($this->context->action->id == 'update') { ?>

    <?= $form->field($model, 'delivery_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?php } ?>

    <?= $form->field($model, 'arrived_in')->hiddenInput()->label(false) ?>

    <?php $allPaymentMethods = ArrayHelper::map(\app\models\PaymentMethod::find()->orderBy('id')->all(), 'id', 'name'); ?>
    <?= $form->field($model, 'paid_with')->dropDownList($allPaymentMethods,['prompt' => ' -- Select Payment Method --'])->label('Payment Method') ?>

    <?= $form->field($model, 'is_disputed')->checkBox() ?>

    <?= $form->field($model, 'refund_status')->dropDownList(['Not Applicable' => 'Not Applicable', 'In Progress' => 'In Progress', 'Fully Refunded' => 'Fully Refunded', 'Partially Refunded' => 'Partially Refunded', 'Escalated' => 'Escalated', 'Lost' => 'Lost']); ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
