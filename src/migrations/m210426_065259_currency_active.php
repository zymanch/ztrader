<?php

use yii\db\Migration;

/**
 * Class m210426_065259_currency_active
 */
class m210426_065259_currency_active extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('currency','active', 'enum("yes","no") not null default "no"');
        $this->execute('update currency set active="yes" where currency_id=1');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210426_065259_currency_active cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210426_065259_currency_active cannot be reverted.\n";

        return false;
    }
    */
}
