<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Courier */

$this->title = 'Create Courier';
$this->params['breadcrumbs'][] = ['label' => 'Couriers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
