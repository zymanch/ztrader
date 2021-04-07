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

        if ($this->db->getTableSchema('trader_imitation', true) === null) {
            $this->execute("CREATE TABLE `trader_imitation` (
                `trader_imitation_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `trader_id` INT(10) UNSIGNED NOT NULL,
                `from` TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                `to` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
                `tick_size` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 1,
                `status` ENUM('waiting','processing','finished') NOT NULL DEFAULT 'waiting',
                `pid` INT(11) NULL DEFAULT NULL,
                `progress` TINYINT(3) UNSIGNED NOT NULL DEFAULT 0,
                PRIMARY KEY (`trader_imitation_id`) USING BTREE,
                INDEX `fk-trader-emitation-trader` (`trader_id`) USING BTREE,
                CONSTRAINT `fk-trader-emitation-trader` FOREIGN KEY (`trader_id`) REFERENCES `trader` (`trader_id`) ON UPDATE CASCADE ON DELETE CASCADE
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB");
        }
        if ($this->db->getTableSchema('trader_history', true) === null) {
            $this->execute("CREATE TABLE `trader_history` (
                `trader_history_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `trader_id` INT(10) UNSIGNED NOT NULL,
                `trader_imitation_id` INT(10) UNSIGNED NULL DEFAULT NULL,
                `buy_trader_history_id` INT(10) UNSIGNED NULL DEFAULT NULL,
                `date` TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                `course` DECIMAL(14,2) UNSIGNED NOT NULL,
                `comission_percent` DECIMAL(6,4) UNSIGNED NOT NULL,
                `action` ENUM('sale','buy') NOT NULL,
                `type` ENUM('virtual','real') NOT NULL,
                PRIMARY KEY (`trader_history_id`) USING BTREE,
                INDEX `fk-trader-history-trader` (`trader_id`) USING BTREE,
                INDEX `fk-trader-history-trader-imitation` (`trader_imitation_id`),
                INDEX `fk-trader-history-trader-history` (`buy_trader_history_id`),
                CONSTRAINT `fk-trader-history-trader` FOREIGN KEY (`trader_id`) REFERENCES `trader` (`trader_id`) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT `fk-trader-history-trader-history` FOREIGN KEY (`buy_trader_history_id`) REFERENCES `trader_history` (`trader_history_id`) ON UPDATE SET NULL ON DELETE SET NULL,
                CONSTRAINT `fk-trader-history-trader-imitation` FOREIGN KEY (`trader_imitation_id`) REFERENCES `trader_imitation` (`trader_imitation_id`) ON UPDATE SET NULL ON DELETE SET NULL
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('trader_imitation');
        $this->dropTable('trader_history');
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
