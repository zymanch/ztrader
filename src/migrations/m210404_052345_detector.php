<?php

use yii\db\Migration;

/**
 * Class m210404_052345_detector
 */
class m210404_052345_detector extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema('currency', true) === null) {
            $this->execute("CREATE TABLE `currency` (
                `currency_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `code` VARCHAR(3) NOT NULL COLLATE 'utf8mb4_unicode_ci',
                `name` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_unicode_ci',
                `position` INT(11) NOT NULL DEFAULT 0,
                PRIMARY KEY (`currency_id`)
            )
            COLLATE='utf8mb4_unicode_ci'
            ENGINE=InnoDB");
            $this->insert('currency',['currency_id'=>1,'code'=>'BTC','name'=>'BitCoin','position'=>1]);
        }
        if ($this->db->getTableSchema('seller', true) === null) {
            $this->execute("CREATE TABLE `seller` (
                `seller_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `type` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
                `name` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
                PRIMARY KEY (`seller_id`)
            )
            COLLATE='utf8mb4_unicode_ci'
            ENGINE=InnoDB");
            $this->execute("INSERT INTO `ztrader`.`seller` (`type`, `name`) VALUES ('none', 'Отсутсвует')");
            $this->execute("INSERT INTO `ztrader`.`seller` (`type`, `name`) VALUES ('simple', 'Границы')");
            $this->execute("INSERT INTO `ztrader`.`seller` (`type`, `name`) VALUES ('ceiling', 'Потолок')");

        }
        if ($this->db->getTableSchema('buyer', true) === null) {
            $this->execute("CREATE TABLE `buyer` (
                `buyer_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `type` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
                `name` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
                PRIMARY KEY (`buyer_id`)
            )
            COLLATE='utf8mb4_unicode_ci'
            ENGINE=InnoDB");
            $this->execute("INSERT INTO `ztrader`.`buyer` (`type`, `name`) VALUES ('none', 'Отсутсвует')");
            $this->execute("INSERT INTO `ztrader`.`buyer` (`type`, `name`) VALUES ('simple', 'Границы')");
            $this->execute("INSERT INTO `ztrader`.`buyer` (`type`, `name`) VALUES ('avg', 'Усредненное')");
            $this->execute("INSERT INTO `ztrader`.`buyer` (`type`, `name`) VALUES ('fall', 'Падение')");
        }
        if ($this->db->getTableSchema('trader', true) === null) {
            $this->execute("CREATE TABLE `trader` (
                `trader_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_unicode_ci',
                `currency_id` INT(10) UNSIGNED NOT NULL,
                `buyer_id` INT(10) UNSIGNED NOT NULL,
                `buyer_options` TEXT NOT NULL DEFAULT '{}' COLLATE 'utf8mb4_unicode_ci',
                `seller_id` INT(10) UNSIGNED NOT NULL,
                `seller_options` TEXT NOT NULL DEFAULT '{}' COLLATE 'utf8mb4_unicode_ci',
                `state` ENUM('selling','buying') NOT NULL DEFAULT 'buying' COLLATE 'utf8mb4_unicode_ci',
                `state_date` TIMESTAMP NOT NULL,
                `status` ENUM('enabled','disabled','paused') NOT NULL DEFAULT 'disabled' COLLATE 'utf8mb4_unicode_ci',
                PRIMARY KEY (`trader_id`),
                INDEX `fk-trader-buyer` (`buyer_id`),
                INDEX `fk-trader-seller` (`seller_id`),
                INDEX `fk-trader-currency` (`currency_id`),
                CONSTRAINT `fk-trader-buyer` FOREIGN KEY (`buyer_id`) REFERENCES `buyer` (`buyer_id`) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT `fk-trader-currency` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`currency_id`) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT `fk-trader-seller` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`seller_id`) ON UPDATE CASCADE ON DELETE CASCADE
            )
            COLLATE='utf8mb4_unicode_ci'
            ENGINE=InnoDB
            ");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('trader');
        $this->dropTable('buyer');
        $this->dropTable('seller');
        $this->dropTable('currency');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210404_052345_detector cannot be reverted.\n";

        return false;
    }
    */
}
