<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CarrierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Перевозчики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrier-index">
	<h3>Список перевозчиков</h3>
	<p class="text-right">
        <?= Html::a('Добавить перевозчика', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
	</p>

    <?php
    Pjax::begin(); ?>
    <?php
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget(
        [
            'dataProvider'     => $dataProvider,
            'filterModel'      => $searchModel,
            'summaryOptions'   => ['class' => 'text-left'],
            'options'          => [
                'class' => 'table-responsive text-center',
            ],
            'tableOptions'     => [
                'class' => 'table table-striped table-bordered text-center',
                'style' => 'display:table;position:relative;',
            ],
            'headerRowOptions' => ['style' => 'text-align:center'],
            'columns'          => [
                //['class' => 'yii\grid\SerialColumn'],
                //'id',
                [
                    'attribute' => 'article',
                    'value'     => 'article',
                    'filter'    => Select2::widget(
                        [
                            'model'         => $searchModel,
                            'attribute'     => 'article',
                            'data'          => $searchModel->getCarrierData('article'),
                            'value'         => $searchModel->article,
                            'options'       => [
                                'class'       => 'form-control',
                                'placeholder' => 'По артиклу'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'min-width'  => '125px',
                            ]
                        ]
                    ),
                ],
                [
                    'attribute' => 'name',
                    'value'     => 'name',
                    'filter'    => Select2::widget(
                        [
                            'model'         => $searchModel,
                            'attribute'     => 'name',
                            'data'          => $searchModel->getCarrierData('name'),
                            'value'         => $searchModel->name,
                            'options'       => [
                                'class'       => 'form-control',
                                'placeholder' => 'По имени'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'min-width'  => '125px',
                            ]
                        ]
                    ),
                ],
                [
                    'attribute' => 'phone',
                    'format'    => 'raw',
                    'value'     => function ($model) {
                        return Html::a($model->phone, 'tel:'.$model->phone);
                    },
                    'filter'    => false,
                ],
                [
                    'class'          => 'yii\grid\ActionColumn',
                    'template'       => '{view} {update}{delete}',
                    'visibleButtons' => ['delete' => Yii::$app->user->can('permissionAdmin')],
                ],
            ],
        ]
    ); ?>

    <?php
    Pjax::end(); ?>

</div>
