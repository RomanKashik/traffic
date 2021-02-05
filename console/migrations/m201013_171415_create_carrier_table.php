<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%carrier}}`.
 */
class m201013_171415_create_carrier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%carrier}}', [
            'id' => $this->primaryKey(),
            'article'=>$this->string(),
            'name'=>$this->string(),
            'phone'=>$this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%carrier}}');
    }
}
