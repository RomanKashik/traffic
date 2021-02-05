<?php

/* @var $this yii\web\View */
/* @var $typePackages \backend\controllers\AppAdmin */
/* @var $clients \backend\controllers\SiteController */
/* @var $totalCost \backend\controllers\SiteController */
/* @var $totalSize \backend\controllers\SiteController */
/* @var $totalWeight \backend\controllers\SiteController */
/* @var $avgCost \backend\controllers\SiteController */
/* @var $totalPack \backend\controllers\SiteController */

$this->title = 'Статистика';
?>
<div class="site-index">

    <div class="body-content">

		<div class="row">
			<div class="col-xs-12">

				<table class="table table-striped">
					<tbody>
					<tr>
						<th>клиентов</th>
						<td><?php
                            echo $clients; ?> чел
						</td>
					</tr>
					<tr>
						<th>общее кол-во упаковок</th>
						<td><?php
                            echo $totalPack; ?> шт
						</td>
					</tr>
                    <?php
                    foreach (  $typePackages as $package) : ?>
						<tr>
							<th>
                                <?php
                                echo $package['name']; ?>
							</th>
							<td>
                                <?php
                                echo $package['count'].' шт'; ?>

							</td>
						</tr>
                    <?php
                    endforeach;; ?>
					<tr>
						<th>общий объем</th>
						<td><?php
                            echo $totalSize; ?> м <sup>3</sup></td>
					</tr>
					<tr>
						<th>общий вес</th>
						<td><?php
                            echo $totalWeight; ?> кг
						</td>
					</tr>
					<tr>
						<th>средняя стоимость посылки</th>
						<td><?php
                            echo $avgCost; ?> руб
						</td>
					</tr>
					<tr>
						<th>общая стоимость</th>
						<td><?php
                            echo $totalCost; ?> руб
						</td>
					</tr>
					</tbody>

				</table>
			</div>
		</div>

    </div>
</div>
