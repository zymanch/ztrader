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
        $this->execute("CREATE TABLE `seller` (
            `seller_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `type` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
            `name` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
            PRIMARY KEY (`seller_id`)
        )
        COLLATE='utf8mb4_unicode_ci'
        ENGINE=InnoDB");
        $this->execute("CREATE TABLE `buyer` (
            `buyer_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `type` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
            `name` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
            PRIMARY KEY (`buyer_id`)
        )
        COLLATE='utf8mb4_unicode_ci'
        ENGINE=InnoDB");
        $this->execute("CREATE TABLE `trader` (
            `trader_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_unicode_ci',
            `buyer_id` INT(10) UNSIGNED NOT NULL,
            `buyer_options` TEXT NOT NULL DEFAULT '{}' COLLATE 'utf8mb4_unicode_ci',
            `seller_id` INT(10) UNSIGNED NOT NULL,
            `seller_options` TEXT NOT NULL DEFAULT '{}' COLLATE 'utf8mb4_unicode_ci',
            `state` ENUM('selling','buying') NOT NULL DEFAULT 'buying' COLLATE 'utf8mb4_unicode_ci',
            `state_date` TIMESTAMP NOT NULL,
            `status` ENUM('enabled','disabled','paused') NOT NULL DEFAULT 'disabled' COLLATE 'utf8mb4_unicode_ci',
            PRIMARY KEY (`trader_id`),
            INDEX `fk-traider-buyer` (`buyer_id`),
            INDEX `fk-traider-seller` (`seller_id`),
            CONSTRAINT `fk-traider-buyer` FOREIGN KEY (`buyer_id`) REFERENCES `buyer` (`buyer_id`) ON UPDATE CASCADE ON DELETE CASCADE,
            CONSTRAINT `fk-traider-seller` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`seller_id`) ON UPDATE CASCADE ON DELETE CASCADE
        )
        COLLATE='utf8mb4_unicode_ci'
        ENGINE=InnoDB");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210404_052345_detector cannot be reverted.\n";

        return false;
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
