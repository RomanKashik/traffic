<?php

use common\models\Carrier;
use common\models\TypeOfPackage;
use common\models\Unit;
use yii\db\Migration;

/**
 * Class m210211_120348_create_default_parameter
 */
class m210211_120348_create_default_parameter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $carrier  = new Carrier();
        $carrier->article = 'СВ';
        $carrier->name = 'Самовывоз';
        $carrier->phone= '+38(071)000-00-00';
        $carrier->save();


        $pack = new TypeOfPackage();
        $pack->name = 'сумка';
        $pack->save();

        $unit = new Unit();
        $unit->name = 'шт';
        $unit->save();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210211_120348_create_default_parameter cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210211_120348_create_default_parameter cannot be reverted.\n";

        return false;
    }
    */
}
