<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Carrier */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Перевозчики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="carrier-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
		<?php if (Yii::$app->user->can('permissionAdmin')) {
           echo Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить этого перевозчика?',
                    'method' => 'post',
                ],
            ]);
		} ;?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'article',
            'name',
           // 'phone',
            [
                'attribute' => 'phone',
                'format' => 'raw',
                'value' => Html::a($model->phone,'tel:'.$model->phone)
            ],
        ],
    ]) ?>

</div>
