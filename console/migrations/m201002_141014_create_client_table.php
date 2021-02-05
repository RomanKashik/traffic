<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 */
class m201002_141014_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'article'=>$this->string(),
            'name'=>$this->string(),
            'phone'=>$this->string(),
            'city'=>$this->string(),
            'area'=>$this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client}}');
    }
}
