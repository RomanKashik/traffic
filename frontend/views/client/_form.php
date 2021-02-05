<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $article common\models\Client */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="client-form">

    <?php
    $form = ActiveForm::begin(
        [
            'fieldConfig' => [
                'template' => '<div class="col-xs-12 col-sm-3 col-md-2">{label}</div>
                            <div class="col-xs-12 col-sm-5 col-md-5">{input}{hint}{error}</div>',
            ],
            'options'     => ['class' => 'form-horizontal'],

        ]
    ); ?>
    <?php
    echo $form->field($model, 'name')->textInput(['placeholder' => 'Ф.И.О', 'autofocus' => true])->hint(
        'Пример: Иванов, Петров'
    ); ?>
    <?php
    echo $form->field($model, 'article')->textInput(['placeholder' => 'Введите артикул'])->hint(
        'Артикул только русскими буквами в верхнем регистре.Например: Д-1'
    ); ?>
    <?php
    echo $form->field($model, 'lastarticle')->textInput(
        ['placeholder' => 'Артикул последнего клиента', 'value' => $article, 'readonly' => '1']
    ); ?>


    <?php
    echo $form->field($model, 'phone')->widget(
        MaskedInput::class,
        [
            'mask' => '+38(071)999-99-99',
            'options' => ['placeholder' => '+38(071)999-99-99']
        ]
    ); ?>
    <?php
    echo $form->field($model, 'city')->textInput(['placeholder' => 'Введите город']); ?>

    <?php
    echo $form->field($model, 'area')->textInput(['placeholder' => 'Введите район / рынок'])->hint('Пример: Пролетарский / Объединенный'); ?>

    <?php
    echo Html::submitButton(
        $model->isNewRecord ? 'Сохранить' : 'Редактировать',
        ['class' => 'btn btn-success btn-sm']
    ) ?>

    <?php
    ActiveForm::end(); ?>

</div>
