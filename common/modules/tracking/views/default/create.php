<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;

?>



<?php echo

Html::beginForm() ?>
<div class="form-group">

    <?php echo Html::label('Артикул') ?>
    <?php echo Html::input('text', 'client_article', '', ['class' => 'form-control', 'required' => true]) ?>

    <?php echo Html::label('Телефон') ?>

    <?php echo MaskedInput::widget(
        [
            'name' => 'client_phone',
            'mask' => '+38(071)999-99-99',
            'options' => ['placeholder' => '+38(071)999-99-99','class' => 'form-control']
        ]
    ); ?>


</div>

<div class="form-group">
    <?php echo Html::submitButton('Поиск', ['class' => 'btn btn-success btn-sm']) ?>
</div>
<?php Html::endForm() ?>


