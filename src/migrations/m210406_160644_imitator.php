<?php

use yii\db\Migration;

/**
 * Class m210406_160644_imitator
 */
class m210406_160644_imitator extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `trader_history` (
            `reader_history_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `trader_id` INT(10) UNSIGNED NOT NULL,
            `date` TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            `course` DECIMAL(14,2) UNSIGNED NOT NULL,
            `comission_percent` DECIMAL(6,4) UNSIGNED NOT NULL,
            `action` ENUM('sale','buy') NOT NULL COLLATE 'utf8_general_ci',
            `type` ENUM('virtual','real') NOT NULL COLLATE 'utf8_general_ci',
            PRIMARY KEY (`reader_history_id`) USING BTREE,
            INDEX `fk-trader-history-trader` (`trader_id`) USING BTREE,
            CONSTRAINT `fk-trader-history-trader` FOREIGN KEY (`trader_id`) REFERENCES `ztrader`.`trader` (`trader_id`) ON UPDATE CASCADE ON DELETE CASCADE
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB");
        $this->execute("CREATE TABLE `trader_imitation` (
            `trader_imitation_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `trader_id` INT(10) UNSIGNED NOT NULL,
            `from` TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            `to` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
            `tick_size` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '1',
            `status` ENUM('waiting','processing','finished') NOT NULL DEFAULT 'waiting' COLLATE 'utf8_general_ci',
            `progress` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
            PRIMARY KEY (`trader_imitation_id`) USING BTREE,
            INDEX `fk-trader-emitation-trader` (`trader_id`) USING BTREE,
            CONSTRAINT `fk-trader-emitation-trader` FOREIGN KEY (`trader_id`) REFERENCES `ztrader`.`trader` (`trader_id`) ON UPDATE CASCADE ON DELETE CASCADE
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210406_160644_imitator cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210406_160644_imitator cannot be reverted.\n";

        return false;
    }
    */
}
