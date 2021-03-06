<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\widgets\Pjax;

?>

<div class="form-group">
    Введите свой <span class="text-info">артикул</span> и <span class="text-info">номер телефона</span> для просмотра статуса заказа.
</div>

<div class="col">
    <?php  Pjax::begin()?>
    <?php echo Html::beginForm() ?>
    <div class="form-group">

        <?php echo Html::label('Артикул') ?>
        <?php echo Html::input('text', 'article', '', ['class' => 'form-control', 'required' => true,'placeholder'=>'Пример артикула: Д-1']) ?>

        <?php echo Html::label('Телефон') ?>
        <?php echo MaskedInput::widget(
            [
                'name' => 'phone',
                'mask' => '+38(071)999-99-99',
                'options' => ['placeholder' => '+38(071)999-99-99', 'class' => 'form-control']
            ]
        ); ?>


    </div>

    <div class="form-group">
        <?php echo Html::submitButton('Поиск', ['class' => 'btn btn-success btn-sm']) ?>
    </div>
    <?php Html::endForm() ?>
    <?php Pjax::end()?>
</div>



