<?php

use common\behaviors\Total;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Экспорт по клиентам';
$this->params['breadcrumbs'][] = $this->title;; ?>


<?php Pjax::begin() ?>


<?php $gridColumns = [
    //['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'user_id',
        'value' => function ($data) {
            return $data->clientReg->client_name;
        },
        'filter' => Select2::widget(
            [
                'model' => $searchModel,
                'attribute' => 'user_id',
                'data' => $searchModel->getClientOrderData('client_name'),
                'value' => $searchModel->clientReg->client_name,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'По клиенту'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '150px',
                ]
            ]
        ),
        'footer' => 'Итого'
    ],
    [
        'attribute' => 'article',
        'label' => 'Артикул',
        'filter' => false,
        'contentOptions' => ['style' => 'text-align:center;'],
        'value' => function ($data) {
            return $data->clientReg->client_article;
        }
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
        'attribute' => 'width',
        'contentOptions' => ['style' => 'text-align:center;'],
        'filter' => false,
    ],
    [
        'attribute' => 'height',
        'contentOptions' => ['style' => 'text-align:center;'],
        'filter' => false,
    ],
    [
        'attribute' => 'length',
        'contentOptions' => ['style' => 'text-align:center;'],
        'filter' => false,
    ],
    [
        'attribute' => 'weight',
        'contentOptions' => ['style' => 'text-align:center;'],
        'filter' => false,
        'footer' => Total::getTotal($dataProvider->models, 'weight'),
    ],
    [
        'attribute' => 'size',
        'contentOptions' => ['style' => 'text-align:center;'],
        'filter' => false,
        'footer' => Total::getTotal($dataProvider->models, 'size') /*. ' <small>м<sup>3</sup></small>'*/,
    ],
    [
        'attribute' => 'cost',
        'contentOptions' => ['style' => 'text-align:center;'],
        'filter' => false,
        'footer' => Total::getTotal($dataProvider->models, 'cost') /*.' <small>руб</small>'*/
    ],
    [
        'attribute' => 'city',
        'label' => 'Город',
        'contentOptions' => ['style' => 'text-align:center;'],
        'value' => function ($data) {
            return $data->clientReg->client_city;
        },
        'filter' => Select2::widget(
            [
                'model' => $searchModel,
                'attribute' => 'city',
                'data' => $searchModel->getClientOrderData('client_city', 'client_city'),
                'value' => $searchModel->city,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'По городу'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'min-width' => '150px',
                ]
            ]
        ),
    ],

    [
        'attribute' => 'area',
        'label' => 'Район',
        'contentOptions' => ['style' => 'text-align:center;'],
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
                    'min-width' => '150px',
                ]
            ]
        ),
    ],
    [
        'attribute' => 'carrier_id',
        'value' => function ($data) {
            return $data->clientReg->client_carrier_article;
        },
        'filter' => Select2::widget(
            [
                'model' => $searchModel,
                'attribute' => 'carrier_id',
                'data' => $searchModel->getCarrierArticles(),
                'value' => $searchModel->clientReg->client_carrier_article,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Перевозчик'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '150px',
                    //'selectOnClose' => true,
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
        'format' => ['date', 'dd-MM-Y'],
    ],

    //['class' => 'yii\grid\ActionColumn'],
]; ?>


<div class="mb-10">
    <?php
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
    ); ?>
</div>

<?php

// You can choose to render your own GridView separately
echo GridView::widget(
    [
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
);

yii\widgets\Pjax::end();; ?>
