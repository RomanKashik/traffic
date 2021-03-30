<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $modelsPack common\models\Pack */

$this->title = $model->clientReg->client_name;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="order-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?php if (Yii::$app->user->can('permissionStock')) {
            echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
        } ?>

        <?php
        if (Yii::$app->user->can('permissionAdmin')) {
            echo Html::a(
                'Удалить',
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger btn-sm ',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить этот заказ?',
                        'method' => 'post',
                    ],
                ]
            );
        }; ?>
    </p>


    <p class="mb-10">
        <?php $gridColumns = [
            [
                'label' => 'Артикул',
                'attribute' => 'clientReg',
                'value' => function ($model) {
                    return $model->clientReg->client_article;
                }
            ],
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return $model->clientReg->client_name;
                }
            ],
            [
                'attribute' => 'packs.name',
                'format' => 'html',
                'value' => function ($model) {
                    $out = '';
                    foreach ($model->packs as $item) {
                        $out .= $item->name . PHP_EOL . '<br>';
                    }
                    return $out;
                }
            ],
            [
                'attribute' => 'packs.count',
                'format' => 'html',
                'value' => function ($model) {
                    $out = '';
                    foreach ($model->packs as $item) {
                        $out .= $item->count.' '.$item->unit->name. PHP_EOL . '<br>';
                    }
                    return $out;
                }
            ],
            [
                'attribute' => 'phone',
                'label' => 'Телефон',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->clientReg->client_phone ? Html::a(
                        $model->clientReg->client_phone,
                        'tel:' . $model->clientReg->client_phone
                    ) : 'не указан';
                },
            ],
            [
                'attribute' => 'type_of_package_id',
                'value' => function ($model) {
                    return $model->type->name;
                }
            ],
            [
                'attribute' => 'carrier_id',
                'value' => function ($model) {
                    return $model->clientReg->client_carrier_name . ' (' . $model->clientReg->client_carrier_article .
                        ')';
                }
            ],
            //'width',
            [
                'attribute' => 'width',
                'label' => 'Ширина <small>(см)</small>',
            ],
            //'height',
            [
                'attribute' => 'height',
                'label' => 'Высота <small>(см)</small>',
            ],
            //'length',
            [
                'attribute' => 'length',
                'label' => 'Длина <small>(см)</small>',
            ],
            //'weight',
            [
                'attribute' => 'weight',
                'label' => 'Вес <small>(кг)</small>',
            ],
            //'size',
            [
                'attribute' => 'size',
                'label' => 'Объём <small>(м<sup>3</sup>)</small>',
            ],
            //'cost',
            [
                'attribute' => 'cost',
                'label' => 'Стоимость <small>(руб.)</small>',
            ],
            [
                'attribute' => 'city',
                'label' => 'Город',
                'value' => function ($model) {
                    return $model->clientReg->client_city ? $model->clientReg->client_city : 'не указан';
                }
            ],
            [
                'attribute' => 'area',
                'label' => 'Район',
                'value' => function ($model) {
                    return $model->clientReg->client_area ? $model->clientReg->client_area : 'не указан';
                }
            ],
            [
                'attribute' => 'notes',
                'label' => 'Примечание',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->notes ? nl2br($model->notes) : 'нет примечаний';
                }

            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y '],
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ]; ?>
        <?php
        // Renders a export dropdown menu
        echo ExportMenu::widget(
            [
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'autoWidth' => true,
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
                    ExportMenu::FORMAT_EXCEL => [],
                ],
                'onRenderSheet' => function ($sheet, $widget) {
                    $styleArray = [
                        // Выравнивание по центру
                        'alignment' => [
                            'horizontal' => GridView::ALIGN_CENTER,
                            'vertical' => GridView::ALIGN_TOP,
                        ],
                    ];
                    // Выравнивание по центру + перенос по словам (Диапазон ячеек, квадрат A2:G100)
                    $sheet->getStyle('A2:Q500')->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
                },
                'filename' => $this->title.' ' . date('d-m-y'),
            ]
        ); ?>

        <?php
        /*
            // Раскоментировать если нужно представление на странице клиента, в виде таблице
            echo GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                ]
            );
            */?>
    </p>





    <?= DetailView::widget(
        [
            'model' => $model,
            'options' => ['class' => 'table table-striped table-bordered detail-view'],
            'attributes' => [
                //'id',
                [
                    'attribute' => 'article',
                    'label' => 'Артикул',
                    'value' => function ($model) {
                        return $model->clientReg->client_article;
                    }
                ],
                [
                    'attribute' => 'user_id',
                    'value' => function ($model) {
                        return $model->clientReg->client_name;
                    }
                ],
                [
                    'attribute' => 'phone',
                    'label' => 'Телефон',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->clientReg->client_phone ? Html::a(
                            $model->clientReg->client_phone,
                            'tel:' . $model->clientReg->client_phone
                        ) : 'не указан';
                    },
                ],
                [
                    'attribute' => 'type_of_package_id',
                    'value' => function ($model) {
                        return $model->type->name;
                    }
                ],
                [
                    'attribute' => 'carrier_id',
                    'value' => function ($model) {
                        return $model->clientReg->client_carrier_name . ' (' . $model->clientReg->client_carrier_article .
                            ')';
                    }
                ],
                //'width',
                [
                    'attribute' => 'width',
                    'label' => 'Ширина <small>(см)</small>',
                ],
                //'height',
                [
                    'attribute' => 'height',
                    'label' => 'Высота <small>(см)</small>',
                ],
                //'length',
                [
                    'attribute' => 'length',
                    'label' => 'Длина <small>(см)</small>',
                ],
                //'weight',
                [
                    'attribute' => 'weight',
                    'label' => 'Вес <small>(кг)</small>',
                ],
                //'size',
                [
                    'attribute' => 'size',
                    'label' => 'Объём <small>(м<sup>3</sup>)</small>',
                ],
                //'cost',
                [
                    'attribute' => 'cost',
                    'label' => 'Стоимость <small>(руб.)</small>',
                ],
                [
                    'attribute' => 'city',
                    'label' => 'Город',
                    'value' => function ($model) {
                        return $model->clientReg->client_city ? $model->clientReg->client_city : 'не указан';
                    }
                ],
                [
                    'attribute' => 'area',
                    'label' => 'Район',
                    'value' => function ($model) {
                        return $model->clientReg->client_area ? $model->clientReg->client_area : 'не указан';
                    }
                ],
                [
                    'attribute' => 'notes',
                    'label' => 'Примечание',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->notes ? nl2br($model->notes) : 'нет примечаний';
                    }

                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:d.m.Y '],
                ],
                /*[
                    'attribute' => 'updated_at',
                    'format'    => ['date', 'php:d-m-Y '],
                ],*/
            ],

        ]
    ) ?>

    <?php
    foreach ($modelsPack as $modalPack) : ?>
        <?= DetailView::widget(
            [
                'model' => $modalPack,
                'options' => ['class' => 'table table-striped table-bordered detail-view'],
                'attributes' => [
                    'name',
                    'count',
                    [
                        'attribute' => 'unit_id',
                        'value' => function ($data) {
                            return $data->unit->name;
                        }
                    ],
                ],

            ]
        ) ?>
    <?php
    endforeach; ?>








</div>
