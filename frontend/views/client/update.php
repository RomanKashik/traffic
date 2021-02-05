<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Client */

$this->title =  $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Список клиентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'редактировать';
?>
<div class="client-update">

    <!--<h1 class="hidden-xs"><?/*= Html::encode($this->title) */?></h1>-->
    <h3 class="visible-xs"><?/*= Html::encode($this->title) */?></h3>



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
