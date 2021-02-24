<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php
$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php
    $this->head() ?>
</head>
<body>
<?php
$this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin(
        [
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
//            'class'=>'container-fluid',
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top navbar-toggle-lg',
            ],
            'renderInnerContainer' => false,
        ]
    );

    if (Yii::$app->user->isGuest) {
//        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    } else {
        if (Yii::$app->user->can('permissionStock') || Yii::$app->user->can('permissionStockDPR')) {
            $menuItems[] =
                ['label' => 'Главная', 'url' => ['/site/index']];
            $menuItems[] =
                [
                    'label' => 'Заказы',
                    'options' => [
                        'data-toggle' => 'collapse',
                        'data-target' => '#sidebar1',
                        'class' => 'dropdown'
                    ],
                    'items' => [
                        [
                            'label' => 'Список заказов',
                            'url' => ['/order/index'],
                            'active' => Yii::$app->controller->id == 'test',
                        ],
                        [
                            'label' => 'Создать заказ',
                            'url' => ['/order/create'],
                            'active' => Yii::$app->controller->id == 'test',
                        ],
                    ],
                ];

            $menuItems[] = ['label' => 'Параметры', 'url' => ['/parameter/index']];
        }
        if (Yii::$app->user->can('permissionMarket')) {
            $menuItems[] =
                [
                    'label' => 'Клиент',
                    'options' => [
                        'data-toggle' => 'collapse',
                        'data-target' => '#sidebar2',
                        'class' => 'dropdown'
                    ],
                    'items' => [
                        [
                            'label' => 'Список клиентов',
                            'url' => ['/client/index'],
                            'active' => Yii::$app->controller->id == 'test',
                        ],
                        [
                            'label' => 'Добавить клиента',
                            'url' => ['/client/create'],
                            'active' => Yii::$app->controller->id == 'test',
                        ],
                        [
                            'label' => 'Оформить клиента',
                            'url' => ['/registr-client/create'],
                            'active' => Yii::$app->controller->id == 'test',
                        ],
                        [
                            'label' => 'Оформленные клиенты',
                            'url' => ['/registr-client/index'],
                            'active' => Yii::$app->controller->id == 'test',
                        ],
                    ],
                    'submenuTemplate' => "\n<ul id='sidebar2' class='nav collapse'>\n{items}\n</ul>\n",
                ];
            $menuItems[] =
                [
                    'label' => 'Перевозчик',
                    'options' => [
                        'data-toggle' => 'collapse',
                        'data-target' => '#sidebar3',
                        'class' => 'dropdown'
                    ],
                    'items' => [
                        [
                            'label' => 'Список перевозчиков',
                            'url' => ['/carrier/index'],
                            'active' => Yii::$app->controller->id == 'test',
                        ],
                        [
                            'label' => 'Добавить перевозчика',
                            'url' => ['/carrier/create'],
                            'active' => Yii::$app->controller->id == 'test',
                        ],
                    ],
                    'submenuTemplate' => "\n<ul id='sidebar3' class='nav collapse'>\n{items}\n</ul>\n",

                ];
        }
        if (Yii::$app->user->can('permissionManager')) {
            $menuItems[] =
                [
                    'label' => 'Упаковочный',
                    'options' => [
                        'data-toggle' => 'collapse',
                        'data-target' => '#sidebar3',
                        'class' => 'dropdown'
                    ],
                    'items' => [
                        [
                            'label' => 'Клиенты',
                            'url' => ['/order/client'],
                            'active' => Yii::$app->controller->id == 'test',
                        ],
                        [
                            'label' => 'Позиции',
                            'url' => ['/pack/index'],
                            'active' => Yii::$app->controller->id == 'test',
                        ],
                    ],
                    'submenuTemplate' => "\n<ul id='sidebar3' class='nav collapse'>\n{items}\n</ul>\n",

                ];
        }
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget(
        [
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]
    );
    NavBar::end();
    ?>

    <div class="container-fluid">
        <?= Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'homeLink' => false,
            ]
        ) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right">Developed by <?
            /*= Yii::powered() */ ?>
            <?= Html::a('Maroder', 'https://vk.com/kashik_roman', ['class' => 'profile-link']) ?></p>
    </div>
</footer>

<?php
$this->endBody() ?>
</body>
</html>


<?php
if (Yii::$app->user->can('permissionAdmin')) {
    $this->registerCss(
        "@media (min-width: 767px) and (max-width: 855px)
{
    wrap > .container,
    .wrap > .container-fluid
    {
        padding: 120px 15px 20px;
    }
}"
    );
}; ?>

<?php
$this->endPage() ?>

