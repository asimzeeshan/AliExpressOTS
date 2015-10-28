<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Store */

$this->title = 'Import Store';
$this->params['breadcrumbs'][] = ['label' => 'Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="store-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'store_number')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

