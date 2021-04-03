<?php

use yii\db\Migration;

/**
 * Class m210315_134310_LogsAndParams
 */
class m210315_134310_LogsAndParams extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('smoke_tests.smoke_test','smoke_tests.test');
        $this->renameColumn('smoke_tests.test','smoke_test_id','test_id');

        $this->createTable('smoke_tests.test_param', [
            'test_param_id' => $this->primaryKey()->unsigned(),
            'test_id'       => \yii\db\Schema::TYPE_INTEGER . ' unsigned default null',
            'name'          => \yii\db\Schema::TYPE_STRING . '(64) not null',
            'value'         => \yii\db\Schema::TYPE_STRING . '(1000) not null',
        ]);

        $this->createTable('smoke_tests.test_log', [
            'test_log_id'      => $this->primaryKey()->unsigned(),
            'test_id'          => \yii\db\Schema::TYPE_INTEGER . ' unsigned not null',
            'response_code'    => \yii\db\Schema::TYPE_SMALLINT . ' unsigned not null',
            'response_time_ms' => 'mediumint unsigned not null ',
            'response'         => \yii\db\Schema::TYPE_TEXT . ' not null',
            'status'           => 'enum("ok","error") not null',
            'error_message'    => \yii\db\Schema::TYPE_TEXT . ' null',
            'created'          => \yii\db\Schema::TYPE_TIMESTAMP . ' not null default current_timestamp()',
        ]);
        $this->addForeignKey('fn_test_param','smoke_tests.test_param','test_id','smoke_tests.test','test_id','cascade','cascade');
        $this->addForeignKey('fn_test_log','smoke_tests.test_log','test_id','smoke_tests.test','test_id','cascade','cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210315_134310_LogsAndParams cannot be reverted.\n";

        return false;
    }
    */
}
