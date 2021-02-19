<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RegistrClient */

$this->title                   = $model->client_name;
$this->params['breadcrumbs'][] = ['label' => 'Оформленные клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="registr-client-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?php
        if (Yii::$app->user->can('permissionAdmin')) {
            echo Html::a(
                'Удалить',
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger btn-sm',
                    'data'  => [
                        'confirm' => 'Уверены, что хотите удалить запись?',
                        'method'  => 'post',
                    ],
                ]
            );
        }; ?>

	</p>

    <?= DetailView::widget(
        [
            'model'      => $model,
            'attributes' => [
                //'id',
                //'client_id',
                //'client_article',
                [
                    'attribute' => 'client_article',
                    'value'     => $model->client_article
                ],
                //'client_name',
                [
                    'attribute' => 'client_name',
                    'value'     => $model->client_name
                ],

                [
                    'attribute' => 'Телефон',
                    'format'    => 'raw',
                    'value'     => Html::a($model->client->phone, 'tel:'.$model->client->phone)
                ],

                [
                    'attribute' => 'client_carrier_id',
                    'value'     => $model->client_carrier_name.' ('.$model->client_carrier_article.')'
                ],
                'count',

                [
                    'attribute' => 'status',
                    'value'     =>  "<span class='text-success'>$model->status </span>",
                    'format'    => 'html',
                ],

                [
                    'attribute' => 'created_at',
                    'format'    => ['date', 'php:d-m-Y '],
                ],

            ],
        ]
    ) ?>

</div>
