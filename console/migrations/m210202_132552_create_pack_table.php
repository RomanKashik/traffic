<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pack}}`.
 */
class m210202_132552_create_pack_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%pack}}',
            [
                'id'       => $this->primaryKey(),
                'user_id'  => $this->integer(),
                'order_id' => $this->integer(),
                'name'     => $this->string(),
                'count'    => $this->string(),
                'unit_id'  => $this->string(),
            ]
        );

        $this->createIndex(
            'fk-pack-order_id',
            'pack',
            'order_id'
        );

        $this->addForeignKey(
            'fk-pack-order_id',
            'pack',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-pack-order_id', 'pack');

        $this->dropIndex('fk-pack-order_id', 'pack');

        $this->dropTable('{{%pack}}');
    }
}
