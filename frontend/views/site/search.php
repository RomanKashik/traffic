<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $q frontend\controllers\SiteController */

?>
	<h4>Ваш запрос: <?php echo $q ? $q : 'укажите позицию для поиска'; ?></h4>

<?= GridView::widget(
    [
        'dataProvider' => $dataProvider,

        'options' => [
            'class' => 'inner table-responsive',
        ],

        'tableOptions'     => ['class' => 'table table-striped table-bordered table-condensed text-center table-order-index'],
        'headerRowOptions' => ['style' => 'text-align:center'],

        'showFooter'       => true,
        'footerRowOptions' => ['style' => 'font-weight:bold;text-decoration: underline;', 'class' => 'success'],

        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],

            [
                'attribute' => 'client_name',
                'label'     => 'Клиент',
                'value'     => function ($data) {
                    return $data['clientReg']['client_name'];
                },
            ],
            [
                'attribute' => 'article',
                'label'     => 'Артикул',
                'value'     => function ($data) {
                    return $data['clientReg']['client_article'];
                },
            ],
            /*  [
                  'attribute'      => 'carrier_id',
                  'label'          => 'Перевозчик',
                  'value'          => function ($data) {
                      return $data['clientReg']['client_carrier_article'];
                  },
                  'contentOptions' => ['style' => 'text-align:center;'],
  //                        'filter'         => Select2::widget(
  //                            [
  //                                'model'         => $searchModel,
  //                                'attribute'     => 'carrier_id',
  //                                'data'          => $searchModel->getCarrierArticles(),
  //                                'value'         => $searchModel->clientReg->client_carrier_article,
  //                                'options'       => [
  //                                    'class'       => 'form-control',
  //                                    'placeholder' => 'Перевозчик',
  //                                ],
  //                                'pluginOptions' => [
  //                                    'allowClear' => true,
  //                                    'width'      => '150px',
  //                                ]
  //                            ]
  //                        ),

              ],*/
            [
                'attribute' => 'width',
				'label'=>'Ширина',
                'value'     => 'width',
            ],
            [
                'attribute' => 'height',
				'label'=>'Высота',
                'value'     => 'height',
            ],
            [
                'attribute' => 'length',
                'label'=>'Длина',
                'value'     => 'length',
            ],
            [
                'attribute' => 'weight',
				'label'=>'Вес',
                'value'     => 'weight',
            ],
            [
                'attribute' => 'size',
                'label'=>'Объём',
                'value'     => 'size',
            ],
            [
                'attribute'      => 'type_of_package_id',
                'label'          => 'Тип упаковки',
                'contentOptions' => ['style' => 'text-align:center;'],
                'filter'         => false,
                'value'          => function ($data) {
                    return $data['type']['name'];
                },
            ],
            [
                'attribute' => 'created_at',
                'label'     => 'Дата',
				'filter'=>'created_at',
//                        'filter'    => kartik\date\DatePicker::widget(
//                            [
//                                'model'         => $searchModel,
//                                'attribute'     => 'date_from',
//                                'attribute2'    => 'date_to',
//                                'type'          => kartik\date\DatePicker::TYPE_RANGE,
//                                'size'          => 'sm',
//                                'separator'     => 'по',
//                                'pluginOptions' => [
//                                    'todayHighlight' => true,
//                                    'weekStart'      => 1, //неделя начинается с понедельника
//                                    'autoclose'      => true,
//                                    'orientation'    => 'bottom auto',
//                                    'clearBtn'       => true,
//                                    'todayBtn'       => 'linked',
//                                    'format'         => 'dd-mm-yyyy',
//                                ],
//
//                                'options'  => [
//                                    'style' => 'width:100px'
//                                ],
//                                'options2' => [
//                                    'style' => 'width:100px'
//                                ]
//                            ]
//                        ),
                'format'    => ['date', 'dd-MM-Y '],
            ],
            /*[
                'attribute' => 'cost',
                'label'     => 'Стоимость',
                'filter'    => false,
//                        'footer'    => Total::getTotal($dataProvider->models, 'cost').' <small>руб</small>'
            ],*/

            /* [
                 'attribute' => 'city',
                 'label'     => 'Город',
                 'value'     => function ($data) {
                     return $data['clientReg']['client_city'];
                 },
 //                        'filter'    => Select2::widget(
 //                            [
 //                                'model'         => $searchModel,
 //                                'attribute'     => 'city',
 //                                'data'          => $searchModel->getClientOrderData('client_city', 'client_city'),
 //                                'value'         => $searchModel->clientReg->client_city,
 //                                'options'       => [
 //                                    'class'       => 'form-control',
 //                                    'placeholder' => 'По городу'
 //                                ],
 //                                'pluginOptions' => [
 //                                    'allowClear' => true,
 //                                ]
 //                            ]
 //                        ),
             ],*/
            /* [
                 'attribute' => 'area',
                 'label'     => 'Район',
                 'value'     => function ($data) {
                     return $data['clientReg']['client_area'];
                 },
 //                        'filter'    => Select2::widget(
 //                            [
 //                                'model'         => $searchModel,
 //                                'attribute'     => 'area',
 //                                'data'          => $searchModel->getClientOrderData('client_area', 'client_area'),
 //                                'value'         => $searchModel->clientReg->client_area,
 //                                'options'       => [
 //                                    'class'       => 'form-control',
 //                                    'placeholder' => 'По району'
 //                                ],
 //                                'pluginOptions' => [
 //                                    'allowClear' => true,
 //                                ]
 //                            ]
 //                        ),
             ],*/

            /*[
                'attribute'      => 'status',
                'contentOptions' => ['style' => 'text-align:center;'],
                'value'          => 'status',
                        'filter'         => Select2::widget(
                            [
                                'model'         => $searchModel,
                                'attribute'     => 'status',
                                'data'          => $searchModel->getStatuses(),
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
            ],*/
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons'  => [
                    'view' => function ($url, $model, $key) {
                        $iconName = "eye-open";
                        //Текст в title ссылки, что виден при наведении
                        $title = \Yii::t('yii', 'Посмотреть');

                        $id      = 'info-'.$key;
                        $options = [
                            'title'      => $title,
                            'aria-label' => $title,
                            'data-pjax'  => '0',
                            'id'         => $id
                        ];

                        $url = Url::to(
                            [
                                'order/view',
                                'id' => $model['id']
                            ]
                        );

                        //Для стилизации используем библиотеку иконок
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                        return Html::a($icon, $url, $options);
                    },
                ],
            ],
        ],
    ]
); ?>
