<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Carrier */

$this->title = 'Добавить перевозчика';
$this->params['breadcrumbs'][] = ['label' => 'Перевозчики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrier-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
