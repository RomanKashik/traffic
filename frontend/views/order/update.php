<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Order */
/* @var $modelsPack frontend\models\Pack */

$this->title = 'Редактировать: ' . $model->clientReg->client_name;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->clientReg->client_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'редактировать';
?>
<div class="order-update">

    <!--<h1 class="hidden-xs"><?/*= Html::encode($this->title) */?></h1>
    <h3 class="visible-xs"><?/*= Html::encode($this->title) */?></h3>-->

    <?= $this->render('_form', [
        'model' => $model,
        'modelsPack'=>$modelsPack,
    ]) ?>

</div>
