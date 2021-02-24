<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\RegistrClient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registr-client-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'client_id')->textInput()->widget(
        Select2::class,
        [
            'name'          => 'client',
            'language'      => 'ru',
            'data'          => $model->getClientData(),
            'options'       => ['placeholder' => 'Выберите клиента ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ) ?>

    <?= $form->field($model, 'client_carrier_id')->textInput(['maxlength' => true])->widget(
        Select2::class,
        [
            'name'          => 'carrier_id',
            'language'      => 'ru',
            'data'          => $model->getCarrierData(),
            'options'       => ['placeholder' => 'Выберите перевозчика ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ) ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'status')->hiddenInput(['value'=>$model::STATUS_ACCEPTED])
		->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
