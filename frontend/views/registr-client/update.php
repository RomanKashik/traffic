<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RegistrClient */

$this->title =  $model->client_name;
$this->params['breadcrumbs'][] = ['label' => 'Оформленные клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->client_article, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'редактирование';
?>
<div class="registr-client-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
