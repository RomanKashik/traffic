<?php

use common\behaviors\Total;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RegistrClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Оформленные клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registr-client-index">

	<!--<h1><?/*= Html::encode($this->title) */?></h1>-->
	<h3>Список оформленных клиентов</h3>

    <?php
    if (Yii::$app->user->can('permissionMarket')) : ?>

		<p class="text-right">
            <?= Html::a('Оформление клиента', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
		</p>
    <?php
    endif; ?>

    <?php
    if (Yii::$app->user->can('permissionStock')) : ?>

		<p class="text-right">
            <?= Html::a('Назад', ['/order/index'], ['class' => 'btn btn-info btn-sm']) ?>
		</p>
    <?php
    endif; ?>

    <?php
    Pjax::begin(); ?>

    <?= GridView::widget(
        [
            'dataProvider'     => $dataProvider,
            'filterModel'      => $searchModel,
            'summaryOptions' => ['class' => 'text-left'],
            'options'          => [
                'class' => 'table-responsive text-center',
            ],
            'tableOptions'     => ['class' => 'table table-striped table-bordered table-condensed text-center table-order-index'],
            'headerRowOptions' => ['style' => 'text-align:center'],
            'showFooter'       => true,
            'footerRowOptions' => ['style' => 'font-weight:bold;text-decoration: underline;', 'class' => 'success'],
            'columns'          => [
                // ['class' => 'yii\grid\SerialColumn'],

                //'id',
                //'client_id',
                //'client_article',
                [
                    'attribute' => 'client_article',
                    'filter'    => false,
                ],
                // 'client_name',
                [
                    'attribute' => 'client_name',
                    'filter'    => false,
                ],
                //'count',
                [
                    'attribute' => 'count',
                    'filter'    => false,
//                'contentOptions' =>['style'=>'text-align:center;'],
                    'footer'    => Total::getTotalCount($dataProvider->models, 'count').' <small>шт</small>'
                ],
                [
                    'attribute' => 'client_carrier_id',
                    'filter'    => false,
                    'value'     => function ($data) {
                        return $data->carrier->article;
                    }
                ],
                [
                    'attribute' => 'status',
//                    'filter'    => false,
					'format'=> 'html',
//					'value'=>'status',
                    'value'     => function ($data) {
                        return "<span class='text-success'>$data->status</span>";
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'filter'    => kartik\date\DatePicker::widget(
                        [
                            'model'      => $searchModel,
                            'attribute'  => 'date_from',
                            'attribute2' => 'date_to',
                            'type'       => kartik\date\DatePicker::TYPE_RANGE,
                            'separator'  => 'по',
                            'size'       => 'sm',

                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'weekStart'      => 1, //неделя начинается с понедельника
                                'autoclose'      => true,
                                'orientation'    => 'bottom auto',
                                'clearBtn'       => true,
                                'todayBtn'       => 'linked',
                                'format'         => 'dd-mm-yyyy',
                            ],
                            'options'  => [
                                'style' => 'min-width:100px'
                            ],
                            'options2' => [
                                'style' => 'min-width:100px'
                            ]

                        ]
                    ),
                    'format'    => ['date', 'd-MM-Y '],
                ],
                //'updated_at',

                [
                    'class'   => 'yii\grid\ActionColumn',
                    'visible' => Yii::$app->user->can('permissionMarket'),
                    'visibleButtons' => ['delete' => Yii::$app->user->can('permissionAdmin')],
                ],
            ],
        ]
    ); ?>

    <?php
    Pjax::end(); ?>

</div>
