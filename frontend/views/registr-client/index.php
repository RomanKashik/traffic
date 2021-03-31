<?php

use common\behaviors\Total;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RegistrClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Оформленные клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
	<div class="registr-client-index">

		<!--<h1><?
        /*= Html::encode($this->title) */ ?></h1>-->
		<h3>Список оформленных клиентов</h3>
		<div class="row mb-10">
			<div class="col-xs-12 col-md-6">
                <?php
                if (Yii::$app->user->can('permissionMarket')) : ?>
                    <?= Html::a(
                        'Оформление клиента',
                        ['create'],
                        ['class' => 'btn btn-success btn-sm mt-10 mt-xs-0']
                    ) ?>
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
        <?php $gridColumns =[
            [
                'class'   => 'yii\grid\CheckboxColumn',
                'visible' => Yii::$app->user->can('permissionAdmin'),
                'header'  => Html::checkBox(
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
                'attribute' => 'client_carrier_article',
                'value'     => function ($data) {
                    return $data->carrier->article;
                }
            ],
            [
                'attribute' => 'client_city',
                'visible' => Yii::$app->user->can('permissionAdmin'),

            ],
            [
                'attribute' => 'status',
//                    'filter'    => false,
                'format'    => 'html',
                'value'     => function ($data) {
                    return "<span class='text-success'>$data->status</span>";
                }
            ],
            [
                'attribute' => 'created_at',
                'filter'    => kartik\date\DatePicker::widget(
                    [
                        'model'         => $searchModel,
                        'attribute'     => 'date_from',
                        'attribute2'    => 'date_to',
                        'type'          => kartik\date\DatePicker::TYPE_RANGE,
                        'separator'     => 'по',
                        'size'          => 'sm',
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'weekStart'      => 1, //неделя начинается с понедельника
                            'autoclose'      => true,
                            'orientation'    => 'bottom auto',
                            'clearBtn'       => true,
                            'todayBtn'       => 'linked',
                            'format'         => 'dd-mm-yyyy',
                        ],
                        'options'       => [
                            'style' => 'min-width:100px'
                        ],
                        'options2'      => [
                            'style' => 'min-width:100px'
                        ]

                    ]
                ),
                'format'    => ['date', 'd-MM-Y '],
            ],
            //'updated_at',

            [
                'class'          => 'yii\grid\ActionColumn',
                'visible'        => Yii::$app->user->can('permissionMarket'),
                'visibleButtons' => [
                    'delete' => Yii::$app->user->can('permissionAdmin'),
                    'update' => function ($model) {
                        return $model->status !== 'готов к выдаче' ||
                            Yii::$app->user->can('permissionAdmin');
                    }
                ],
            ],
           /* [
                'id'               => 'grid',
                'dataProvider'     => $dataProvider,
                'filterModel'      => $searchModel,
                'summaryOptions'   => ['class' => 'text-left'],
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

                ],
            ],*/
			];
        ?>

		<?php if (Yii::$app->user->can('permissionAdmin')) {

            // Renders a export dropdown menu
            echo ExportMenu::widget(
                [
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'autoWidth' => false,
                    'showConfirmAlert' => false,
                    'target' => ExportMenu::TARGET_SELF,
                    'dropdownOptions' => [
                        'label' => 'Выгрузить',
                        'class' => 'btn btn-outline-secondary'
                    ],
                    'exportConfig' => [
                        ExportMenu::FORMAT_PDF => false,
                        ExportMenu::FORMAT_TEXT => false,
                        ExportMenu::FORMAT_HTML => false,
                        ExportMenu::FORMAT_CSV => false,
                        ExportMenu::FORMAT_EXCEL => ['filename' => 'Клиенты ' . date('d-m-y')],
                    ],

                    'filename' => 'Клиенты ' . date('d-m-y')
                ]
            );
		} ;?>



		<?php echo GridView::widget(
		[
        'id'               => 'grid',
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => $gridColumns,
		'hover' => true,
		'resizableColumns' => false,
		'persistResize' => false,
		'hideResizeMobile' => false,
		'responsiveWrap' => false,
		'showFooter' => true,
		'footerRowOptions' => ['style' => 'font-weight:bold;text-decoration: underline;', 'class' => 'success'],

		]
		);?>

        <?php
        Pjax::end(); ?>

	</div>
<?php
$deleteAll = <<< JS
 let keys = $('#grid').yiiGridView('getSelectedRows');

$("#deleteAll").on('click',function(){
    let keys = $('#grid').yiiGridView('getSelectedRows');
    
    
    $.ajax({
            type: 'POST',
            url : 'multiple-delete',
            data : {row_id_to_delete: keys},
            success : function() {
              $(this).closest('tr').remove(); //or whatever html you use for displaying rows
            },
          
        });
   
    });
JS;

$this->registerJs($deleteAll, $position = View::POS_READY, $key = null);
