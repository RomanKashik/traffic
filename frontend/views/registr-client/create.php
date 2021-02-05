<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RegistrClient */

$this->title = 'Оформление клиента';
$this->params['breadcrumbs'][] = ['label' => 'Оформленные клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registr-client-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
