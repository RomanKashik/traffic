<?php

use common\behaviors\Total;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список заказов';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="order-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row mb-10">
        <div class="col-xs-12 col-md-6">
            <?php
            if (Yii::$app->user->can('permissionStock')) : ?>

                <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success btn-sm mt-10 mt-xs-0']) ?>

                <?php if (Yii::$app->user->can('stockmanDPR') || Yii::$app->user->can('permissionAdmin')) : ?>
                    <input type="button" class="btn btn-primary btn-sm mt-10 mt-xs-0" value="Проверен"
                           id="checkAll">
                <?php endif; ?>

                <?= Html::a(
                    'Клиенты оформленные на рынке',
                    ['/registr-client/index'],
                    ['class' => 'btn btn-info btn-sm mt-10 mt-xs-0']
                ) ?>
            <?php endif; ?>
        </div>
    </div>


    <?php
    Pjax::begin() ?>
    <div class="scrolling outer">
        <?= GridView::widget(
            [
                'id' => 'grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,

                'options' => [
                    'class' => 'inner table-responsive',
                ],

                'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed text-center table-order-index'],
                'headerRowOptions' => ['style' => 'text-align:center'],

                'showFooter' => true,
                'footerRowOptions' => ['style' => 'font-weight:bold;text-decoration: underline;', 'class' => 'success'],

                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'visible' => Yii::$app->user->can('stockmanDPR'),
                        'header' => Html::checkBox(
                            'check_all',
                            false,
                            [
                                'class' => 'select-on-check-all',
                                'label' => 'Проверен'
                            ]
                        ),
//                        'name' => 'check',
                        'checkboxOptions' => [
                            'class' => 'checkbox',
                            'value' => $model->weight
                        ]

                    ],

                    [
                        'attribute' => 'user_id',
                        'value' => function ($data) {
                            return $data->clientReg->client_name;
                        },
                        'filter' => Select2::widget(
                            [
                                'model' => $searchModel,
                                'attribute' => 'user_id',
                                'data' => $searchModel->getClientOrderData('client_name', 'client_name'),
                                'value' => $searchModel->clientReg->client_name,
                                'options' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'По клиенту'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'min-width' => '125px'
                                ]
                            ]
                        ),
                    ],
                    [
                        'attribute' => 'article',
                        'label' => 'Артикул',
                        'filter' => false,
                        'value' => function ($data) {
                            return $data->clientReg->client_article;
                        }
                    ],
                    [
                        'attribute' => 'carrier_id',
                        'label' => 'Перевозчик',
                        'value' => function ($data) {
                            return $data->clientReg->client_carrier_article;
                        },
                        'contentOptions' => ['style' => 'text-align:center;'],
                        'filter' => Select2::widget(
                            [
                                'model' => $searchModel,
                                'attribute' => 'carrier_id',
                                'data' => $searchModel->getCarrierArticles(),
                                'value' => $searchModel->clientReg->client_carrier_article,
                                'options' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'Перевозчик',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'width' => '150px',
                                ]
                            ]
                        ),
                        'footer' => 'Итого'
                    ],
                    //'width',
                    //'height',
                    //'weight',
                    //'length',
                    [
                        'attribute' => 'cost',
                        'filter' => false,
                        'footer' => Total::getTotal($dataProvider->models, 'cost') . ' <small>руб</small>'
                    ],
                    [
                        'attribute' => 'type_of_package_id',
                        'contentOptions' => ['style' => 'text-align:center;'],
                        'filter' => false,
                        'value' => function ($data) {
                            return $data->type->name;
                        },
                    ],
                    [
                        'attribute' => 'city',
                        'label' => 'Город',
                        'value' => function ($data) {
                            return $data->clientReg->client_city;
                        },
                        'filter' => Select2::widget(
                            [
                                'model' => $searchModel,
                                'attribute' => 'city',
                                'data' => $searchModel->getClientOrderData('client_city', 'client_city'),
                                'value' => $searchModel->clientReg->client_city,
                                'options' => [
                                    'class' => 'form-control',
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
                        'label' => 'Район',
                        'value' => function ($data) {
                            return $data->clientReg->client_area;
                        },
                        'filter' => Select2::widget(
                            [
                                'model' => $searchModel,
                                'attribute' => 'area',
                                'data' => $searchModel->getClientOrderData('client_area', 'client_area'),
                                'value' => $searchModel->clientReg->client_area,
                                'options' => [
                                    'class' => 'form-control',
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
                        'filter' => kartik\date\DatePicker::widget(
                            [
                                'model' => $searchModel,
                                'attribute' => 'date_from',
                                'attribute2' => 'date_to',
                                'type' => kartik\date\DatePicker::TYPE_RANGE,
                                'size' => 'sm',
                                'separator' => 'по',
                                'pluginOptions' => [
                                    'todayHighlight' => true,
                                    'weekStart' => 1, //неделя начинается с понедельника
                                    'autoclose' => true,
                                    'orientation' => 'bottom auto',
                                    'clearBtn' => true,
                                    'todayBtn' => 'linked',
                                    'format' => 'dd-mm-yyyy',
                                ],

                                'options' => [
                                    'style' => 'width:100px'
                                ],
                                'options2' => [
                                    'style' => 'width:100px'
                                ]
                            ]
                        ),
                        'format' => ['date', 'dd-MM-Y '],
                    ],
                    [
                        'attribute' => 'status',
                        'contentOptions' => ['style' => 'text-align:center;'],
                        'value' => 'status',
                        'filter' => Select2::widget(
                            [
                                'model' => $searchModel,
                                'attribute' => 'status',
                                'data' => $searchModel->getStatus(),
                                'value' => $searchModel->status,
                                'options' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'По статусу'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ]
                            ]
                        ),
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
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


$checkAll = <<< JS

$("#checkAll").on('click',function(){
    let keys = $('#grid').yiiGridView('getSelectedRows');
      console.log(keys);
   /* $.ajax({
            type: 'POST',
            url : 'multiple-check',
            data : {row_id_to_update: keys},
            success : function() {
              $(this).closest('tr').remove(); //or whatever html you use for displaying rows
            }
        });*/
    });
JS;

$this->registerJs($checkAll, $position = View::POS_READY, $key = null);

?>
