<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%type_of_package}}`.
 */
class m201002_144548_create_type_of_package_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%type_of_package}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%type_of_package}}');
    }
}
