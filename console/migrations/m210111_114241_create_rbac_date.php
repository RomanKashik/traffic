<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m210111_114241_create_rbac_date
 */
class m210111_114241_create_rbac_date extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        //Создаем разрешения
        $permissionMarket              = $auth->createPermission('permissionMarket');
        $permissionMarket->description = 'Создание, редактирование клиентов. Оформление заявки клиента';
        //$permissionMarket->ruleName   = 'Разрешения рынка';
        $auth->add($permissionMarket);


        $permissionStock              = $auth->createPermission('permissionStock');
        $permissionStock->description = 'Создание, редактирование заказов. ';
        //$permissionStock->ruleName    = 'Разрешения склада';
        $auth->add($permissionStock);

        $permissionStockDPR              = $auth->createPermission('permissionStockDPR');
        $permissionStockDPR->description = 'Отмечать проверенные и отгруженные заказы';
        //$permissionStockDPR->ruleName    = 'Разрешения склада в ДНР';
        $auth->add($permissionStockDPR);


        $permissionManager              = $auth->createPermission('permissionManager');
        $permissionManager->description = 'Выгрузка упаковочного листа по клиентам и позициям';
       // $permissionManager->ruleName    = 'Разрешения менеджера';
        $auth->add($permissionManager);

        $permissionDriver              = $auth->createPermission('permissionDriver');
        $permissionDriver->description = 'Просмотр списка оформленных клиентов';
        //$permissionDriver->ruleName    = 'Разрешения водителя';
        $auth->add($permissionDriver);

        $permissionAdmin              = $auth->createPermission('permissionAdmin');
        $permissionAdmin->description = 'Полный доступ ко всмем параметрам и вкладкам';
        //$permissionAdmin->ruleName = 'Разрешения Администратора';
        $auth->add($permissionAdmin);

        //Создаем роли
        $marketRole              = $auth->createRole('market');
        $marketRole->description = 'Сотрудник рынка';
        $auth->add($marketRole);
        $auth->addChild($marketRole, $permissionMarket);


        $stockmanRole              = $auth->createRole('stockman');
        $stockmanRole->description = 'Сотрудник склада';
        $auth->add($stockmanRole);
        $auth->addChild($stockmanRole, $permissionStock);


        $stockmanRoleDPR              = $auth->createRole('stockmanDPR');
        $stockmanRoleDPR->description = 'Сотрудник склада в ДНР';
        $auth->add($stockmanRoleDPR);
        $auth->addChild($stockmanRoleDPR, $permissionStockDPR);


        $managerRole              = $auth->createRole('manager');
        $managerRole->description = 'Менеджер';
        $auth->add($managerRole);
        $auth->addChild($managerRole, $permissionManager);

        $driverRole              = $auth->createRole('driver');
        $driverRole->description = 'Водитель';
        $auth->add($driverRole);
        $auth->addChild($driverRole, $permissionDriver);

        $adminRole              = $auth->createRole('admin');
        $adminRole->description = 'Администратор';
        $auth->add($adminRole);
        $auth->addChild($adminRole, $permissionAdmin);
        $auth->addChild($adminRole, $marketRole);
        $auth->addChild($adminRole, $stockmanRole);
        $auth->addChild($adminRole, $stockmanRoleDPR);
        $auth->addChild($adminRole, $managerRole);
        $auth->addChild($adminRole, $driverRole);


        $user                = new User();
        $user->email         = 'admin@admin.ru';
        $user->username      = 'Админ';
        $user->password_hash = '$2y$13$P9.d7KUb8C6BHCvkdzMsrOi5U.vIAw01UmriB.34PiN50e8nTGFge';
        $user->status        = 10;


        $user->generateAuthKey();
        $user->save();

        $auth->assign($adminRole, $user->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210111_114241_create_rbac_date cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210111_114241_create_rbac_date cannot be reverted.\n";

        return false;
    }
    */
}
