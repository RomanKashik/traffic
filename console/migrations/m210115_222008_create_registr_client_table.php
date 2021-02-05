<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%registr_client}}`.
 */
class m210115_222008_create_registr_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%registr_client}}',
            [
                'id'                     => $this->primaryKey(),
                'client_id'              => $this->integer(),
                'client_article'         => $this->string(),
                'client_name'            => $this->string(),
                'client_phone'           => $this->string(),
                'client_city'            => $this->string(),
                'client_area'            => $this->string(),
                'client_carrier_id'      => $this->string(),
                'client_carrier_article' => $this->string(),
                'client_carrier_name'    => $this->string(),
                'client_carrier_phone'   => $this->string(),
                'count'                  => $this->integer(),
                'status'                 => $this->string(),
                'created_at'             => $this->integer(),
                'updated_at'             => $this->integer(),
            ]
        );

        $this->createIndex(
            'fk-registr_client-client_id',
            'registr_client',
            'client_id'
        );

        $this->addForeignKey(
            'fk-registr_client-client_id',
            'registr_client',
            'client_id',
            'client',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-registr_client-client_id', 'registr_client');

        $this->dropIndex('fk-registr_client-client_id', 'registr_client');

        $this->dropTable('{{%registr_client}}');
    }
}
