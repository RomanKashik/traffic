<?php

/* @var $this yii\web\View */

/* @var $searchModel common\models\OrderSearch */

use common\models\Order;
use yii\console\widgets\Table;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;


$this->title = 'TRAFFIC';
?>
<div class="site-index">
	<div class="body-content">
		<div class="row">
			<div class="col-xs-12">
					<h1>Инструкция</h1>
                <?php
                if (Yii::$app->user->can('permissionMarket')): ?>
					<ol class="instruction">
						<li>Добавить <?php
                            echo Html::a(
                                'перевозчика',
                                ['/carrier/create/'],
                                ['class' => 'text-primary']
                            ); ?>
							<ol class="instruction">
								<li>После регистрации перевозчика, он будет доступен в поле "Перевозчик", на вкладке
									"Оформление клиента"
								</li>
							</ol>
						</li>
						<li>Добавить <?php
                            echo Html::a('клиента', '/client/create'); ?>
							<ol class="instruction">
								<li>Все поля в форме обязательны к заполнению</li>
								<li>Примеры заполнения приведены ниже поля ввода</li>
								<li>В поле "Последний артикул" будет выводиться артикул последнего добавленного клиента.
									Артикул должен быть уникальным
								</li>
								<li>После регистрации клиента, он будет доступен в поле "Клиент", на вкладке
									"Оформление клиента"
								</li>
							</ol>
						</li>
						<li> <?php
                            echo Html::a(
                                'Оформление клиента',
                                ['/registr-client/create'],
                                ['class' => 'text-primary']
                            ); ?>
							<ol class="instruction">
								<li>Выбрать в выпадающем списке клиента</li>
								<li>Выбрать в выпадающем списке перевозчика</li>
								<li>Добавить количество мест</li>
							</ol>
						</li>
					</ol>
                <?php
                endif; ?>

                <?php
                if (Yii::$app->user->can('permissionManager')): ?>
					<ol class="instruction">
						<li>
							Для выгрузки отчета, перейдите по вкладке нужного отчета
							<ol class="instruction">
								<li>Выберите поля которые нужны для отчета (по-умолчанию выбраны все поля)</li>
								<li>Кликнете на иконку "Выгрузить"</li>
								<li>Сохраните отчет</li>
							</ol>
						</li>
						<li>В отчете будут доступны фильтры по выбранным полям</li>
					</ol>
                <?php
                endif; ?>

                <?php
                if (Yii::$app->user->can('permissionStock')): ?>
                    <ol class="instruction">
                        <li>
                            Добавить <?php
                            echo Html::a('параметры', ['/parameter/index'], ['class' => 'text-primary']);
                            ?> следуя инструкции на странице с параметрами
                            <ol class="instruction">
                                <li>После добавления параметров, они будут доступны в выпадающих полях с
                                    параметрами
                                </li>
                            </ol>
                        </li>
                        <li><?php
                            echo Html::a('Создать заказ', ['/order/create'], ['class' => 'text-primary']);
                            ?>
                        </li>
                        <li>Выберите из выпадающего списка клиента
                            <ol class="instruction">
                                <li>В списке клиенты, которые были оформленны на рынке</li>
                                <li>Отсортированны по дате сдачи посылки</li>
                                <li>Рядом с фамилией указано кол-во мест</li>
                            </ol>
                        </li>
                        <li>Объём и стоимость считаются автоматически</li>
                        <li>Поле примечание не является обязательным
                            <ol class="instruction">
                                <li>В нем можно указывать на дефекты упаковки, не соответствие кол-ва позиций и т.д</li>
                            </ol>
                        </li>
                        <li>Обязательно указать статус заказа "Оформлен"</li>
                        <li>После изменения статуса заказа на складе выдачи, возможность редактировать заказ
                            пропадает (статус будет иметь значение "Готов к выдаче")</li>
                        <li>На вкладке <?php
                            echo Html::a('Список заказов', ['/order/index'], ['class' => 'text-primary']);
                            ?> Вы можете посмотреть кол-во клиентов и мест которые оформленны на рынке.
                            <ol class="instruction">
                                <li>Для этого следует перейти по ссылке <?php
                                    echo Html::a(
                                        'Клиенты оформленные на рынке',
                                        ['/registr-client/index'],
                                        ['class' => 'text-primary']
                                    );
                                    ?></li>
                            </ol>
                        </li>
                        <li>У Вас есть возможность просматривать и редактировать  заказы
                            <ol class="instruction">
                                <li>Для этого следует у определенного клиента кликнуть на нужную иконку</li>
                            </ol>
                        </li>
                    </ol>
                <?php
                endif; ?>
                <?php
                if (Yii::$app->user->can('permissionStockDPR')): ?>
                    <ol class="instruction">
                        <li>
                           Вы можете редактировать, просматривать заказы оформленные работником склада загрузки
                        </li>
                        <li>После проверки кол-ва мест клиента, необходимо поставить статус "Проверен" (на странице с
                            списком заказов) или статус "Готов к выдаче" (на странице конкретного заказа)</li>
                        <li>После изменения статуса заказа на "Проверен" или "Готов к выдаче" возможность
                            редактировать заказ пропадает</li>
                    </ol>
                <?php
                endif; ?>
			</div>
		</div>
	</div>
</div>
