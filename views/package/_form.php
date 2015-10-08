<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Package */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="package-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ae_order_id')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php if ($this->context->action->id == 'update') { ?>

    <?= $form->field($model, 'delivery_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?php } ?>

    <?= $form->field($model, 'arrived_in')->hiddenInput()->label(false) ?>

    <?php $allPaymentMethods = ArrayHelper::map(\app\models\PaymentMethod::find()->orderBy('id')->all(), 'id', 'name'); ?>
    <?= $form->field($model, 'paid_with')->dropDownList($allPaymentMethods)->label('Payment Method') ?>

    <?= $form->field($model, 'is_disputed')->checkBox() ?>

    <?= $form->field($model, 'refund_status')->dropDownList(['Not Applicable' => 'Not Applicable', 'In Progress' => 'In Progress', 'Fully Refunded' => 'Fully Refunded', 'Partially Refunded' => 'Partially Refunded', 'Escalated' => 'Escalated', 'Lost' => 'Lost']); ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
