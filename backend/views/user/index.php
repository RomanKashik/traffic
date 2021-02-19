<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user common\models\User */

$this->title                   = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

	<p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
	</p>

    <?php
    Pjax::begin(); ?>
    <?php
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                // ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'username',
                //'auth_key',
                // 'password_hash',
                //'password_reset_token',
                [
                    'attribute' => 'roles',
                    'value'     => function ($user) {
                        return implode(',', $user->getRoles());
                    }
                ],
                //'email:email',
                //'status',
                // 'created_at',
                [
                    'attribute' => 'created_at',
                    'format'    => ['date', 'php:d-m-Y']
                ],
                //'updated_at',
                //'verification_token',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    ); ?>

    <?php
    Pjax::end(); ?>

</div>
