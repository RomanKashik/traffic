<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Client */
/* @var $article frontend\models\Client */


$this->title = 'Добавить клиента';
$this->params['breadcrumbs'][] = ['label' => 'Список клиентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">

    <!--<h2  class="hidden-xs"><?/*= Html::encode($this->title) */?></h2>
	<h3 class="visible-xs"><?/*= Html::encode($this->title) */?></h3>-->

    <?= $this->render('_form', [
        'model' => $model,
        'article' => $article,
    ]) ?>

</div>
