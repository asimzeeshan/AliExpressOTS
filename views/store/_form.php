<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\Store */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'store_number')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php $data = \app\models\Store::find()
        ->select(['location as value', 'location as  label','id'])->addGroupBy('location')
        ->asArray()
        ->all(); ?>
    <?= $form->field($model, 'location')->widget(\yii\jui\AutoComplete::className(), [
        'options' => ['class' => 'form-control'],
        'class' => 'form-control',
        'clientOptions' => [
            'source' => $data,
            'autoFill'=>true,
            'minLength'=>'2',
        ],
    ]) ?>

    <?= $form->field($model, 'since')->widget(\yii\jui\DatePicker::classname(), [
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'changeMonth' => true,
            'yearRange' => '1998:2016',
            'changeYear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

