<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%pack}}`.
 */
class m210328_153935_add_created_at_and_updated_at_column_to_pack_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('pack', 'created_at', $this->integer());
        $this->addColumn('pack', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('pack', 'created_at');
        $this->dropColumn('pack', 'updated_at');
    }
}
