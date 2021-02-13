<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Список клиентов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

	<!-- <h1><?
    /*= Html::encode($this->title) */ ?></h1>-->
	<h3>Список зарегистрированных клиентов</h3>

	<p class="text-right">
        <?= Html::a('Добавить клиента', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
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
//                [
//                    'class' => 'yii\grid\CheckboxColumn',
//                    // вы можете настроить дополнительные свойства здесь.
//                ],
                // ['class' => 'yii\grid\SerialColumn'],
                //'id',
                [
                    'attribute' => 'article',
                    'value'     => 'article',
                    'filter'    => Select2::widget(
                        [
                            'model'         => $searchModel,
                            'attribute'     => 'article',
                            'data'          => $searchModel->getClientQueryData('article'),
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
                            'data'          => $searchModel->getClientQueryData('name'),
                            'value'         => $searchModel->name,
                            'options'       => [
                                'class'       => 'form-control',
                                'placeholder' => 'По клиенту'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'min-width'  => '125px',
                            ]
                        ]
                    ),
                ],
                [
                    'attribute' => 'city',
                    'value'     => 'city',
                    'filter'    => Select2::widget(
                        [
                            'model'         => $searchModel,
                            'attribute'     => 'city',
                            'data'          => $searchModel->getClientQueryData('city'),
                            'value'         => $searchModel->city,
                            'options'       => [
                                'class'       => 'form-control',
                                'placeholder' => 'По городу'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'min-width'  => '150px',
                            ]
                        ]
                    ),
                    'footer'    => 'Итого'
                ],
                [
                    'attribute' => 'area',
                    'value'     => 'area',
                    'filter'    => Select2::widget(
                        [
                            'model'         => $searchModel,
                            'attribute'     => 'area',
                            'data'          => $searchModel->getClientQueryData('area'),
                            'value'         => $searchModel->area,
                            'options'       => [
                                'class'       => 'form-control',
                                'placeholder' => 'По району'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'min-width'  => '150px',
                            ]
                        ]
                    ),
                    'footer'    => 'Итого'
                ],
                [
                    'attribute' => 'phone',
                    'format'    => 'raw',
                    'value'     => function ($model) {
                        return Html::a($model->phone, 'tel:'.$model->phone);
                    },
                    'filter'    => false
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
