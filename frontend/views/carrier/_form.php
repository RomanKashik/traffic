<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\Carrier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carrier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'article')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'phone')->widget(MaskedInput::class, [
        'mask' => '+38(071)999-99-99',
        'options' => ['placeholder' => '+38(071)999-99-99']
    ]); ?>

    <div class="form-group">
        <?php echo Html::submitButton(
            $model->isNewRecord ? 'Сохранить' : 'Редактировать',
            ['class' => 'btn btn-success btn-sm']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
