<?php



?>
<aside class="main-sidebar">

	<section class="sidebar">

		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
			</div>
			<div class="pull-left info">
				<p><?php echo Yii::$app->user->identity->username;?></p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<!-- search form -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search..."/>
				<span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
			</div>
		</form>
		<!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items'   => [
                    ['label' => 'Категории', 'options' => ['class' => 'header']],
                    ['label' => 'Статистика','icon'=>'pie-chart', 'url' => ['site/index']],
                    [
                        'label' => 'Пользователи',
                        'icon'  => 'users',
                        'url'   => '/admin/user/',
                        'items' => [
                            [
                                'label' => 'Список пользователей ',
                                'icon'  => 'list',
                                'url'   =>
                                    ['/user/index'],
                            ],
                            ['label' => 'Добавить пользователя', 'icon' => 'user-plus', 'url' => ['/user/create'],],
                        ],
                    ],
                    [
                        'label' => 'Клиенты',
                        'icon'  => 'users',
                        'url'   => '/client/index',
                        'items' => [
                            [ 'label' => 'Список клиентов ', 'icon'  => 'list', 'url'   => ['/client/index'],],
                            ['label' => 'Добавить клиента', 'icon' => 'user-plus', 'url' => ['/client/create'],],
                            ['label' => 'Список оформленных', 'icon' => 'user-plus', 'url' =>
                                ['/registr-client/index'],],
                            ['label' => 'Оформить клиента', 'icon' => 'user-plus', 'url' => ['/registr-client/create'],],
                        ],
					],
                    [
                        'label' => 'Заказы',
                        'icon'  => 'shopping-cart',
                        'url'   => '/order/index',
                        'items' => [
                            [
                                'label' => 'Список заказов ',
                                'icon'  => 'cart-arrow-down',
                                'url'   =>
                                    ['/order/index'],
                            ],
                            ['label' => 'Добавить заказ', 'icon' => 'cart-plus', 'url' => ['/order/create'],],
                        ],
                    ],
                    ['label' => 'Параметры','icon'=>'wrench', 'url' => ['/parameter/index']],
                    [
                        'label' => 'Перевозчик',
                        'icon'  => 'truck',
                        'url'   => '/carrier/index',
                        'items' => [
                            [
                                'label' => 'Список перевозчиков ',
                                'icon'  => 'truck',
                                'url'   =>
                                    ['/carrier/index'],
                            ],
                            ['label' => 'Добавить перевозчика', 'icon' => 'truck', 'url' => ['/carrier/create'],],
                        ],
                    ],
                    ['label' => 'Отладка', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Дэбаг',
                        'icon'  => 'bug',
                        'url'   => '/admin/user/',
                        'items' => [
                            [
                                'label' => 'Gii',
                                'icon'  => 'file-code-o',
                                'url'   => ['/gii'],
                            ],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                        ],
                    ],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],

                ],
            ]
        ) ?>



	</section>

</aside>
