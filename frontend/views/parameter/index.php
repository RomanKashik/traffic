<?php
/* @var $this yii\web\view */

/* @var $type \frontend\models\TypeOfPackage */

/** @var $unit \frontend\models\Unit */

use yii\widgets\ActiveForm;
use yii\helpers\Html;


$this->title                   = 'Добавить параметры';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-12 col-sm-6">
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($type, 'name')->textInput(['placeholder' => 'Введите один тип упаковки'])->hint(
        'Например: мешок, сумка, баул, пакет...'
    ); ?>

    <?php echo Html::submitButton(
        'Добавить',
        [
            'class' => 'btn btn-success',
        ]
    ); ?>

    <?php ActiveForm::end(); ?>
</div>

<div class="col-12 col-sm-6 mt-sm-10">
    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $form->field($unit, 'name')->textInput(['placeholder' => 'Введите единицу измерения'])->hint(
        'Например: шт, упак, пар, кг...'
    ); ?>

    <?php echo Html::submitButton(
        'Добавить',
        [
            'class' => 'btn btn-success',
        ]
    ); ?>

    <?php ActiveForm::end(); ?>
</div>

<div class="clearfix"></div>
<div class="col-12 my-10">
	<div class="alert alert-info" role="alert">
		<strong>Важно!</strong> Добавлять параметры необходимо последовательно!
		<p><small>Пример: Указать тип упаковки <i class="glyphicon glyphicon-arrow-right" aria-hidden="true"></i> Добавть.</small></p>
		<p><small>Указать единицу измерения <i class="glyphicon glyphicon-arrow-right" aria-hidden="true"></i> Добавть.</small></p>
	</div>
</div>