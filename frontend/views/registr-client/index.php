<?php

use common\behaviors\Total;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RegistrClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Оформленные клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="registr-client-index">

        <!--<h1><? /*= Html::encode($this->title) */ ?></h1>-->
        <h3>Список оформленных клиентов</h3>
        <div class="row mb-10">
            <div class="col-xs-12 col-md-6">
                <?php
                if (Yii::$app->user->can('permissionMarket')) : ?>
                        <?= Html::a('Оформление клиента', ['create'], ['class' => 'btn btn-success btn-sm mt-10 mt-xs-0']) ?>
                        <?php
                        if (Yii::$app->user->can('permissionAdmin')) : ?>
                            <input type="button" class="btn btn-danger btn-sm mt-10 mt-xs-0" value="Удалить выбранные"
                                   id="deleteAll">
                            <?php
                            // echo $this->render('_search', ['model' => $searchModel]); ?>
                        <?php
                        endif; ?>
                <?php
                endif; ?>
                <?php
                if (Yii::$app->user->can('permissionStock')) : ?>
                        <?= Html::a('Назад', ['/order/index'], ['class' => 'btn btn-info btn-sm mt-10 mt-xs-0']) ?>
                <?php
                endif; ?>
            </div>
        </div>
        <?php
        Pjax::begin(); ?>

        <?= GridView::widget(
            [
                'id' => 'grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'summaryOptions' => ['class' => 'text-left'],
                'options' => [
                    'class' => 'table-responsive text-center',
                ],
                'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed text-center table-order-index'],
                'headerRowOptions' => ['style' => 'text-align:center'],
                'showFooter' => true,
                'footerRowOptions' => ['style' => 'font-weight:bold;text-decoration: underline;', 'class' => 'success'],
                'columns' => [
                    // ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    //'client_id',
                    //'client_article',
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'visible' => Yii::$app->user->can('permissionAdmin'),
                        'header' => Html::checkBox(
                            'selection_all',
                            false,
                            [
                                'class' => 'select-on-check-all',
                                'label' => 'Все'
                            ]
                        ),
                    ],
                    [
                        'attribute' => 'client_article',
                        'filter' => false,
                    ],
                    // 'client_name',
                    [
                        'attribute' => 'client_name',
                        'filter' => false,
                    ],
                    //'count',
                    [
                        'attribute' => 'count',
                        'filter' => false,
//                'contentOptions' =>['style'=>'text-align:center;'],
                        'footer' => Total::getTotalCount($dataProvider->models, 'count') . ' <small>шт</small>'
                    ],
                    [
                        'attribute' => 'client_carrier_id',
                        'filter' => false,
                        'value' => function ($data) {
                            return $data->carrier->article;
                        }
                    ],
                    [
                        'attribute' => 'status',
//                    'filter'    => false,
                        'format' => 'html',
//					'value'=>'status',
                        'value' => function ($data) {
                            return "<span class='text-success'>$data->status</span>";
                        }
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => kartik\date\DatePicker::widget(
                            [
                                'model' => $searchModel,
                                'attribute' => 'date_from',
                                'attribute2' => 'date_to',
                                'type' => kartik\date\DatePicker::TYPE_RANGE,
                                'separator' => 'по',
                                'size' => 'sm',
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
                                    'style' => 'min-width:100px'
                                ],
                                'options2' => [
                                    'style' => 'min-width:100px'
                                ]

                            ]
                        ),
                        'format' => ['date', 'd-MM-Y '],
                    ],
                    //'updated_at',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'visible' => Yii::$app->user->can('permissionMarket'),
                        'visibleButtons' => [
                        		'delete' => Yii::$app->user->can('permissionAdmin'),
							'update'=>function ($model) {
                                return $model->status !== 'Готов к выдаче';
                            }
						],
                    ],
                ],
            ]
        ); ?>

        <?php
        Pjax::end(); ?>

    </div>
<?php
$deleteAll = <<< JS

$("#deleteAll").on('click',function(){
    let keys = $('#grid').yiiGridView('getSelectedRows');
      console.log(keys);
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

$this->registerJs($deleteAll, $position = View::POS_READY, $key = null);
