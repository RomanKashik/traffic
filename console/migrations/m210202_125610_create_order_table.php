<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m210202_125610_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer(),
            'carrier_id'=>$this->integer(),
            'type_of_package_id'=>$this->string(),
            'width'=>$this->string(),
            'height'=>$this->string(),
            'weight'=>$this->string(),
            'length'=>$this->string(),
            'size'=>$this->string(),
            'cost'=>$this->string(),
            'notes'=>$this->text(),
            'status'=>$this->string(),
            'created_at'=>$this->integer(11),
            'updated_at'=>$this->integer(11),
        ]);

        $this->createIndex(
            'fk-order-user_id',
            'order',
            'user_id'
        );

        $this->addForeignKey(
            'fk-order-user_id',
            'order',
            'user_id',
            'registr_client',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-order-user_id', 'order');

        $this->dropIndex('fk-order-user_id', 'order');

        $this->dropTable('{{%order}}');
    }
}
