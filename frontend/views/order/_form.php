<?php

use common\models\TypeOfPackage;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use romanmaroder\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $modelsPack common\models\Pack */
/* @var $type TypeOfPackage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php
    $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?php
    echo $form->field($model, 'user_id')->textInput()->widget(
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

	<?php /*echo'<pre>';var_dump($model->getClientData()) ;*/?>

    <?php
/*    echo $form->field($model, 'carrier_id')->textInput()->widget(
           Select2::class,
           [
               'name'          => 'carrier_id',
               'language'      => 'ru',
               'data'          => $model->checkCount(),
               'options'       => ['placeholder' => 'Выберите артикул ...'],
               'pluginOptions' => [
                   'allowClear' => true
               ],
           ]
       )  */?>



    <?php
    echo $form->field($model, 'type_of_package_id')->textInput(['maxlength' => true])->widget(
        Select2::class,
        [
            'name'          => 'client',
            'language'      => 'ru',
            'data'          => $model->getTypePackage(),
            'options'       => ['placeholder' => 'Тип упаковки ...'],
            'pluginOptions' => [
                'allowClear'              => true,
                'minimumResultsForSearch' => -1,
            ],
        ]
    ) ?>

    <?php
    echo $form->field($model, 'width')->textInput(
        ['maxlength' => true, 'type' => 'number', 'step' => '0.01', 'placeholder' => 'Ширина']
    )->label
    (
        'Ширина (<small>см</small>)'
    ) ?>

    <?php
    echo $form->field($model, 'height')->textInput(
        ['maxlength' => true, 'type' => 'number', 'step' => '0.01', 'placeholder' => 'Высота']
    )->label
    (
        'Высота (<small>см</small>)'
    ) ?>

    <?php
    echo $form->field($model, 'length')->textInput(
        ['maxlength' => true, 'type' => 'number', 'step' => '0.01', 'placeholder' => 'Длина']
    )->label
    (
        'Длина (<small>см</small>)'
    ) ?>

    <?php
    echo $form->field($model, 'weight')->textInput(
        ['maxlength' => true, 'type' => 'number', 'step' => '0.01', 'placeholder' => 'Вес']
    )->label
    (
        'Вес (<small>кг</small>)'
    ) ?>

    <?php
    echo $form->field($model, 'rate')->label(false)->hiddenInput(['value' => $model->getRate()]); ?>

    <?php
    echo $form->field($model, 'size')->textInput(
        ['maxlength' => true, 'readonly' => 'readonly', 'placeholder' => 'Объём']
    )->label
    (
        'Объём (<small>м<sup>3</sup></small>)'
    ) ?>

    <?php
    echo $form->field($model, 'cost')->textInput(
        ['maxlength' => true, 'readonly' => 'readonly', 'placeholder' => 'Стоимость']
    )->label
    (
        'Стоимость (<small>руб</small>)'
    ) ?>

    <?
    /*= $form->field($model, 'date')->textInput() */ ?>


    <?
    /*= $form->field($model, 'date_update')->textInput() */ ?>


	<div class="row">
		<!--		<div class="panel panel-default">-->
		<!--			<div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Наименование</h4></div>-->
		<div class="panel-body">
            <?php
            DynamicFormWidget::begin(
                [
                    'widgetContainer' => 'dynamicform_wrapper',
                    // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody'      => '.container-items',
                    // required: css class selector
                    'widgetItem'      => '.item',
                    // required: css class
                    'limit'           => 200,
                    // the maximum times, an element can be cloned (default 999)
                    'min'             => 1,
                    // 0 or 1 (default 1)
                    'insertButton'    => '.add-item',
                    // css class
                    'deleteButton'    => '.remove-item',
                    // css class
                    'model'           => $modelsPack[0],
                    'formId'          => 'dynamic-form',
                    'formFields'      => [
                        'name',
                        'count',
                        'unit_id',
                    ],
                ]
            ); ?>
			<div class="container-items"><!-- widgetContainer -->
                <?php
                foreach ($modelsPack as $i => $modelPack): ?>
					<div class="item panel panel-default"><!-- widgetBody -->
						<div class="panel-heading">
							<h3 class="panel-title pull-left">Добавить позицию</h3>
                            <?php
                            // necessary for update action.
                            if (!$modelPack->isNewRecord) {
                                $disabled = 'disabled';
                            }; ?>
							<div class="pull-right">
								<button type="button" class="add-item btn btn-success btn-xs" <?php
                                echo $disabled; ?>><i
											class="glyphicon glyphicon-plus"></i></button>
								<button type="button" class="remove-item btn btn-danger btn-xs " <?php
                                echo $disabled; ?>><i
											class="glyphicon glyphicon-minus"></i></button>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (!$modelPack->isNewRecord) {
                                echo Html::activeHiddenInput($modelPack, "[{$i}]id");
                            }
                            ?>
                            <?php
                            echo $form->field($modelPack, "[{$i}]name")
                                ->textInput(['enableAjaxValidation' => true]) ?>
							<div class="row">
								<div class="col-xs-5 col-sm-6 ">
                                    <?php
                                    echo $form->field($modelPack, "[{$i}]count")->textInput(
                                        [
                                            'maxlength'            => true,
                                            'class'                => 'form-control 
                                            count',
                                            'enableAjaxValidation' => true
                                        ]
                                    ) ?>
								</div>
								<div class="col-xs-7 col-sm-6 ">
                                    <?php
                                    echo $form->field($modelPack, "[{$i}]unit_id")->textInput(
                                        ['maxlength' => true,]
                                    )->widget(
                                        Select2::class,
                                        [
                                            'name'          => 'client',
                                            'language'      => 'ru',
                                            'data'          => $modelPack->getUnits(),
                                            'options'       => ['placeholder' => 'Ед.измерения ...'],
                                            'pluginOptions' => [
                                                'allowClear'              => true,
                                                'minimumResultsForSearch' => -1,
                                            ],
                                        ]
                                    ) ?>
								</div>
							</div>

						</div>
					</div>
                <?php
                endforeach; ?>
			</div>
            <?php
            DynamicFormWidget::end(); ?>
		</div>
		<!--		</div>-->
	</div>

    <?php
    echo $form->field($model, 'notes')->textarea(['placeholder' => 'Примечания', 'style' => 'resize:vertical']); ?>
    <?php
    if (Yii::$app->user->can('permissionStockDPR')) {

        echo $form->field($model, 'status')->checkbox(['value'=>$model::STATUS_CHECKED])->label('Проверен');

    }; ?>

	<?php    if (Yii::$app->user->can('permissionStock')) {
        echo $form->field($model, 'status')->checkbox(['value'=>$model::STATUS_ISSUED])->label('Оформлен');
	} ;?>

	<div class="form-group">
        <?php
        echo Html::submitButton(
            $model->isNewRecord ? 'Сохранить' : 'Редактировать',
            ['class' => 'btn btn-success btn-sm']
        ) ?>
	</div>

    <?php
    ActiveForm::end(); ?>

</div>

