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
        $this->execute("CREATE TABLE `detector` (
            `detector_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `type` VARCHAR(50) NOT NULL DEFAULT 'simple' COLLATE 'utf8mb4_unicode_ci',
            `name` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_unicode_ci',
            `currency_id` INT(11) UNSIGNED NOT NULL,
            `options` TEXT NOT NULL DEFAULT '{}' COLLATE 'utf8mb4_unicode_ci',
            `status` ENUM('yes','no') NOT NULL DEFAULT 'no' COLLATE 'utf8mb4_unicode_ci',
            PRIMARY KEY (`detector_id`),
            INDEX `fk-detector-currency` (`currency_id`),
            CONSTRAINT `fk-detector-currency` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`currency_id`) ON UPDATE CASCADE ON DELETE CASCADE
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
