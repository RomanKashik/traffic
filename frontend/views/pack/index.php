<?php

use common\behaviors\Total;
use frontend\models\Pack;
use kartik\export\ExportMenu;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2Asset;

Select2Asset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title                   = 'Экспорт по позициям';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="pack-index">

	<!--<h1><? /*= Html::encode($this->title) */ ?></h1>-->

	<!--<p>
        <? /*= Html::a('Create Pack', ['create'], ['class' => 'btn btn-success']) */ ?>
	</p>-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin() ?>

    <?php $gridColumns = [
        //['class' => 'yii\grid\SerialColumn'],

        //'id',
        [
            'attribute' => 'name',
            'value'     => 'name',
            'filter'    => Select2::widget(
                [
                    'model'         => $searchModel,
                    'attribute'     => 'name',
                    'data'          => $searchModel->getPackName(),
                    'options'       => [
                        'class'       => 'form-control',
                        'placeholder' => 'По наименованию'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ),
        ],

        [
            'attribute'      => 'count',
            'contentOptions' => ['style' => 'text-align:center;'],
            'filter'         => false,
            'footer'         => Total::getTotal($dataProvider->models, 'count'),
        ],

        [
            'attribute'      => 'unit_id',
            'contentOptions' => ['style' => 'text-align:center;'],
            'value'          => function ($data) {
                return $data->unit->name;
            },
            'filter'         => Select2::widget(
                [
                    'model'         => $searchModel,
                    'attribute'     => 'unit_id',
                    'data'          => $searchModel->getUnitPack(),
                    'value'         => $searchModel->unit->name,
                    'options'       => [
                        'class'       => 'form-control',
                        'placeholder' => 'По ед.измерения'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]
            ),
        ]
        //['class' => 'yii\grid\ActionColumn'],
    ]; ?>


	<div class="mb-10">
        <?php
        // Renders a export dropdown menu
        echo ExportMenu::widget(
            [
                'dataProvider'     => $dataProvider,
                'columns'          => $gridColumns,
                'autoWidth'        => false,
                'showConfirmAlert' => false,
                'target'           => ExportMenu::TARGET_SELF,
                //'pjaxContainerId' => 'kv-pjax-container',
                'dropdownOptions'  => [
                    'label' => 'Выгрузить',
                    'class' => 'btn btn-outline-secondary'
                ],
                'exportConfig'     => [
                    ExportMenu::FORMAT_PDF   => false,
                    ExportMenu::FORMAT_TEXT  => false,
                    ExportMenu::FORMAT_HTML  => false,
                    ExportMenu::FORMAT_CSV   => false,
                    ExportMenu::FORMAT_EXCEL => ['filename' => 'Позиции '.date('d-M-y')],
                ],

                'filename' => 'Позиции '.date('d-M-y')
            ]
        ); ?>
	</div>
    <?php

    // You can choose to render your own GridView separately
    echo \kartik\grid\GridView::widget(
        [
            'dataProvider'     => $dataProvider,
            'filterModel'      => $searchModel,
            'columns'          => $gridColumns,
            //'pjax' => true,
            //'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
            'resizableColumns' => false,
            'persistResize'    => false,
            'hideResizeMobile' => false,
            'responsiveWrap'   => false,
            'showFooter'       => true,
            'footerRowOptions' => ['style' => 'font-weight:bold;text-decoration: underline;', 'class' => 'success'],
        ]
    );
    yii\widgets\Pjax::end(); ?>
</div>
