<?php
/* @var $this yii\web\View */
/* @var $typePackages \backend\controllers\AppAdmin */
/* @var $clients \frontend\controllers\PackController */
/* @var $totalPack \frontend\controllers\PackController */
/* @var $totalValue \frontend\controllers\PackController */


$this->title = 'Статистика';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-xs-12">
                <?php foreach ($totalValue as $value) :?>
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
                                echo $value['count_package']; ?> шт
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
                        endforeach; ?>
                        <tr>
                            <th>общий объем</th>
                            <td><?php
                                echo number_format($value['size'],'2','.',''); ?> м <sup>3</sup></td>
                        </tr>
                        <tr>
                            <th>общий вес</th>
                            <td><?php
                                echo number_format($value['weight'],'2','.','');; ?> кг
                            </td>
                        </tr>
                        <tr>
                            <th>средняя стоимость посылки</th>
                            <td><?php
                                echo number_format($value['average_cost'],'2','.',''); ?> руб
                            </td>
                        </tr>
                        <tr>
                            <th>общая стоимость</th>
                            <td><?php
                                echo number_format($value['cost'],'2','.',''); ?> руб
                            </td>
                        </tr>
                        </tbody>

                    </table>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>