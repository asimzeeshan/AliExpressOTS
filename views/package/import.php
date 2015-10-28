<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Package */

$this->title = 'Import Package';
$this->params['breadcrumbs'][] = ['label' => 'Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="package-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'order_id')->textInput() ?>
        <?= $form->field($model, 'product_url')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
