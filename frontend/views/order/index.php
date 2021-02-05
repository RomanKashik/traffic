<?php

use common\behaviors\Total;
use common\models\Order;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Список заказов';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="order-index">

	<h3><?= Html::encode($this->title) ?></h3>

    <?php
    if (Yii::$app->user->can('permissionStock')) : ?>

		<p class="text-right">
            <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            <?= Html::a(
                'Клиенты оформленные на рынке',
                ['/registr-client/index'],
                ['class' => 'btn btn-info btn-sm']
            ) ?>
		</p>
    <?php
    endif; ?>
    <?php
    if (Yii::$app->user->can('permissionAdmin')) : ?>
		<p class="text-right"><input type="button" class="btn btn-danger btn-sm" value="Удалить выбранные" id="deleteAll"></p>
        <?php
        // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    endif; ?>
    <?php
    Pjax::begin() ?>
	<div class="scrolling outer">
        <?= GridView::widget(
            [
                'id'           => 'grid',
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,

                'options' => [
                    'class' => 'inner table-responsive',
                ],

                'tableOptions'     => ['class' => 'table table-striped table-bordered table-condensed text-center table-order-index'],
                'headerRowOptions' => ['style' => 'text-align:center'],

                'showFooter'       => true,
                'footerRowOptions' => ['style' => 'font-weight:bold;text-decoration: underline;', 'class' => 'success'],

                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        'class'           => 'yii\grid\CheckboxColumn',
                        'visible'=>Yii::$app->user->can('permissionAdmin'),
                        'header' => Html::checkBox(
                            'selection_all',
                            false,
                            [
                                'class' => 'select-on-check-all',
                                'label' => 'Все'
                            ]
                        ),
                    ],
                    //'id',
                    [
                        'attribute' => 'user_id',
                        'value'     => function ($data) {
                            return $data->clientReg->client_name;
                        },
                        'filter'    => Select2::widget(
                            [
                                'model'         => $searchModel,
                                'attribute'     => 'user_id',
                                'data'          => $searchModel->getClientOrderData('client_name'),
                                'value'         => $searchModel->clientReg->client_name,
                                'options'       => [
                                    'class'       => 'form-control',
                                    'placeholder' => 'По клиенту'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ]
                            ]
                        ),
                    ],
                    [
                        'attribute' => 'article',
                        'label'     => 'Артикул',
                        'filter'    => false,
                        'value'     => function ($data) {
                            return $data->clientReg->client_article;
                        }
                    ],
                    [
                        'attribute'      => 'carrier_id',
                        'label'          => 'Перевозчик',
                        'value'          => function ($data) {
                            return $data->clientReg->client_carrier_article;
                        },
                        'contentOptions' => ['style' => 'text-align:center;'],
                        'filter'         => Select2::widget(
                            [
                                'model'         => $searchModel,
                                'attribute'     => 'carrier_id',
                                'data'          => $searchModel->getCarrierArticles(),
                                'value'         => $searchModel->clientReg->client_carrier_article,
                                'options'       => [
                                    'class'       => 'form-control',
                                    'placeholder' => 'Перевозчик',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'width'      => '150px',
                                ]
                            ]
                        ),
                        'footer'         => 'Итого'
                    ],
                    //'width',
                    //'height',
                    //'weight',
                    //'length',

                    /*[
                        'attribute' => 'size',
                        'filter'    => false,
                        'contentOptions' =>['style'=>'text-align:center;'],
                        'footer'    => Order::getTotal($dataProvider->models, 'size').' <small>м<sup>3</sup></small>',
                    ],*/
                    /*[
                        'attribute' => 'weight',
                        'filter' => false,
                        'contentOptions' =>['style'=>'text-align:center;'],
                        'footer'=>Order::getTotal($dataProvider->models, 'weight'),
                    ],*/

                    [
                        'attribute' => 'cost',
                        'filter'    => false,
                        'footer'    => Total::getTotal($dataProvider->models, 'cost').' <small>руб</small>'
                    ],
                    [
                        'attribute'      => 'type_of_package_id',
                        'contentOptions' => ['style' => 'text-align:center;'],
                        'filter'         => false,
                        'value'          => function ($data) {
                            return $data->type->name;
                        },
                    ],
                    [
                        'attribute' => 'city',
                        'label'     => 'Город',
                        'value'     => function ($data) {
                            return $data->clientReg->client_city;
                        },
                        'filter'    => Select2::widget(
                            [
                                'model'         => $searchModel,
                                'attribute'     => 'city',
                                'data'          => $searchModel->getClientOrderData('client_city', 'client_city'),
                                'value'         => $searchModel->clientReg->client_city,
                                'options'       => [
                                    'class'       => 'form-control',
                                    'placeholder' => 'По городу'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ]
                            ]
                        ),
                    ],
                    [
                        'attribute' => 'area',
                        'label'     => 'Район',
                        'value'     => function ($data) {
                            return $data->clientReg->client_area;
                        },
                        'filter'    => Select2::widget(
                            [
                                'model'         => $searchModel,
                                'attribute'     => 'area',
                                'data'          => $searchModel->getClientOrderData('client_area', 'client_area'),
                                'value'         => $searchModel->clientReg->client_area,
                                'options'       => [
                                    'class'       => 'form-control',
                                    'placeholder' => 'По району'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ]
                            ]
                        ),
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter'    => kartik\date\DatePicker::widget(
                            [
                                'model'         => $searchModel,
                                'attribute'     => 'date_from',
                                'attribute2'    => 'date_to',
                                'type'          => kartik\date\DatePicker::TYPE_RANGE,
                                'size'          => 'sm',
                                'separator'     => 'по',
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
                                    'style' => 'width:100px'
                                ],
                                'options2' => [
                                    'style' => 'width:100px'
                                ]
                            ]
                        ),
                        'format'    => ['date', 'dd-MM-YYYY '],
                    ],
                    [
                        'attribute'      => 'status',
                        'contentOptions' => ['style' => 'text-align:center;'],
                        'value'          => 'status',
                        'filter'         => Select2::widget(
                            [
                                'model'         => $searchModel,
                                'attribute'     => 'status',
                                'data'          => $searchModel->getStatus(),
                                'value'         => $searchModel->status,
                                'options'       => [
                                    'class'       => 'form-control',
                                    'placeholder' => 'По статусу'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ]
                            ]
                        ),
                    ],
                    [
                        'class'          => 'yii\grid\ActionColumn',
                        'template'       => '{view} {update} {delete}',
                        'visibleButtons' => [
                            'delete' => Yii::$app->user->can('permissionAdmin'),
                            'update' => Yii::$app->user->can('permissionStock') || Yii::$app->user->can(
                                    'permissionStockDPR'
                                ),
                        ],
                    ],
                ],
            ]
        ); ?>
	</div>
    <?php
    yii\widgets\Pjax::end(); ?>
</div>
<?php
$js = <<< JS

$("#deleteAll").on('click',function(){
    let keys = $('#grid').yiiGridView('getSelectedRows');
     $.ajax({
            type: 'POST',
            url : 'multiple-delete',
            data : {row_id_to_delete: keys},
            success : function() {
              $(this).closest('tr').remove(); //or whatever html you use for displaying rows
            }
        });
    });
JS;

$this->registerJs($js, $position = View::POS_READY, $key = null);
?>​