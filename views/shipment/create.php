<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Shipment */

$this->title = 'New Shipment';
$this->params['breadcrumbs'][] = ['label' => 'Shipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
