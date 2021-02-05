<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Уверен?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'username',
            //'auth_key',
            //'password_hash',
           // 'password_reset_token',
            'email:email',
            'status',
            [
                'attribute' => 'roles',
                'value' => function($user) {
                    /* @var $user User */
                    return implode(',', $user->getRoles());
                }
            ],
           // 'created_at',
            [
                'attribute' => 'created_at',
                'format'=>['date','php:d-F-Y']
            ],
            //'updated_at',
            [
                'attribute' => 'updated_at',
                'format'=>['date','php:d-F-Y']
            ],
           // 'verification_token',
        ],
    ]) ?>

</div>
