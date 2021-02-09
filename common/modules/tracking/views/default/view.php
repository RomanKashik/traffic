<?php

use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="tracking-default-index">
                <?php
                echo GridView::widget(
                    [
                        'dataProvider' => $dataProvider,
                        'options' => [
                            'class' => 'table-responsive',
                        ],
                        'tableOptions' => [
                            'class' => 'table table-striped table-bordered ',
                        ],
                        'columns' => [
                            [
                                'attribute' => 'Артикул',
                                'value' => 'client_article',
                            ],
                            [
                                'attribute' => 'Ф.И.О',
                                'value' => 'client_name',
                            ],
                            [
                                'attribute' => 'Телефон',
                                'value' => 'client_phone',
                            ],
                            [
                                'attribute' => 'Мест',
                                'value' => 'count',
                            ],
                            [
                                'attribute' => 'Статус',
                                'value' => 'status',
                            ],
                            [
                                'attribute' => 'Дата',
                                'value' => 'created_at',
                                'format' => ['date', 'php:d-m-Y '],
                            ]
                        ]
                    ]
                ); ?>

            </div>
        </div>
        <div class="col">
            <?php echo Html::a('Назад',['default/index'],['class'=>'btn btn-success btn-sm'])?>
        </div>
    </div>

</div>