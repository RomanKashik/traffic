<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Order */
/* @var $modelsPack frontend\models\Pack */

$this->title = 'Создать заказ';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-create">

    <?= $this->render('_form', [
        'model' => $model,
		'modelsPack'=>$modelsPack,
    ]) ?>

</div>
