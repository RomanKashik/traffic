<?php


/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $modelsPack common\models\Pack */

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
