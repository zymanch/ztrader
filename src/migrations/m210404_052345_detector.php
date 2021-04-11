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

            $this->execute("INSERT INTO `currency` VALUES (1, 'BTC', 'BitCoin', 1)");
            $this->execute("INSERT INTO `currency` VALUES (2, 'XRP', 'Ripple', 2)");
            $this->execute("INSERT INTO `currency` VALUES (3, 'ETH', 'Ethereum', 3)");
            $this->execute("INSERT INTO `currency` VALUES (4, 'BNB', 'Binance Coin', 4)");
            $this->execute("INSERT INTO `currency` VALUES (5, 'XLM', 'Stellar Lumens', 5)");
            $this->execute("INSERT INTO `currency` VALUES (6, 'LTC', 'Litecoin', 6)");
            $this->execute("INSERT INTO `currency` VALUES (7, 'DOG', 'DogeCoin', 7)");
            $this->execute("INSERT INTO `currency` VALUES (8, 'GRT', 'The Graph', 8)");
            $this->execute("INSERT INTO `currency` VALUES (9, 'ALG', 'Algorand', 9)");
            $this->execute("INSERT INTO `currency` VALUES (10, 'COM', 'Compound', 10)");
            $this->execute("INSERT INTO `currency` VALUES (11, 'SNX', 'Synthetix Network Token', 11)");
            $this->execute("INSERT INTO `currency` VALUES (12, 'YFI', 'yearn.finance', 12)");
            $this->execute("INSERT INTO `currency` VALUES (13, 'CAK', 'PancakeSwap', 13)");
            $this->execute("INSERT INTO `currency` VALUES (14, 'GRT', 'GrtDown', 14)");
            $this->execute("INSERT INTO `currency` VALUES (15, 'MKR', 'Maker', 15)");
            $this->execute("INSERT INTO `currency` VALUES (16, 'TOM', 'TomoChain', 16)");
            $this->execute("INSERT INTO `currency` VALUES (17, 'BUS', 'BUSD', 17)");
            $this->execute("INSERT INTO `currency` VALUES (18, 'BCH', 'Bitcoin Cash', 18)");
            $this->execute("INSERT INTO `currency` VALUES (19, 'ADA', 'Cardano', 19)");
            $this->execute("INSERT INTO `currency` VALUES (20, 'BAT', 'Basic Attention Token', 20)");
            $this->execute("INSERT INTO `currency` VALUES (21, 'MAT', 'Polygon', 21)");
            $this->execute("INSERT INTO `currency` VALUES (22, 'VET', 'VeChain', 22)");
            $this->execute("INSERT INTO `currency` VALUES (23, 'HBA', 'Hedera Hashgraph', 23)");
            $this->execute("INSERT INTO `currency` VALUES (24, 'ATO', 'Cosmos', 24)");
            $this->execute("INSERT INTO `currency` VALUES (25, 'CHZ', 'Chiliz', 25)");
            $this->execute("INSERT INTO `currency` VALUES (26, 'LIN', 'ChainLink', 26)");
            $this->execute("INSERT INTO `currency` VALUES (27, 'QTU', 'Qtum', 27)");
            $this->execute("INSERT INTO `currency` VALUES (28, 'DOT', 'Polkadot', 28)");
            $this->execute("INSERT INTO `currency` VALUES (29, 'DAI', 'Dai', 29)");
            $this->execute("INSERT INTO `currency` VALUES (30, 'ZEC', 'Zcash', 30)");
            $this->execute("INSERT INTO `currency` VALUES (31, 'ZIL', 'Ziliqa', 31)");
            $this->execute("INSERT INTO `currency` VALUES (32, 'BTT', 'BitTorrent', 32)");
            $this->execute("INSERT INTO `currency` VALUES (33, 'DAS', 'Dash', 33)");
            $this->execute("INSERT INTO `currency` VALUES (34, 'EOS', 'EOS', 34)");
            $this->execute("INSERT INTO `currency` VALUES (35, 'NAN', 'NANO', 35)");
            $this->execute("INSERT INTO `currency` VALUES (36, 'PAX', 'Paxos Standart', 36)");
            $this->execute("INSERT INTO `currency` VALUES (37, 'TRX', 'TRON', 37)");
            $this->execute("INSERT INTO `currency` VALUES (38, 'USD', 'TetherUS', 38)");
            $this->execute("INSERT INTO `currency` VALUES (39, 'XTZ', 'Tezos', 39)");
            $this->execute("INSERT INTO `currency` VALUES (40, 'ETC', 'Ethereum Classic', 40)");

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
            $this->execute("INSERT INTO `ztrader`.`seller` (`type`, `name`) VALUES ('barrier', 'Потолок')");
            $this->execute("INSERT INTO `ztrader`.`seller` (`type`, `name`) VALUES ('grow', 'Рост')");

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
