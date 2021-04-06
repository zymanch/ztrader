<?php

use yii\db\Migration;

/**
 * Class m210403_044140_init_app
 */
class m210403_044140_init_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema('user', true) === null) {
            $this->execute("CREATE TABLE `user` (
                `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(64) NOT NULL,
                `role` SET('admin','receipt','trader') NOT NULL DEFAULT 'receipt,trader',
                `email` VARCHAR(128) NOT NULL,
                `password` VARCHAR(64) NOT NULL,
                `auth_key` VARCHAR(64) NOT NULL,
                `created` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`user_id`),
                UNIQUE INDEX `user-username` (`username`),
                UNIQUE INDEX `user-email` (`email`)
            )
            COLLATE='latin1_swedish_ci'
            ENGINE=InnoDB
            ");
        }
        if ($this->db->getTableSchema('receipt', true) === null) {
            $this->execute("CREATE TABLE `receipt` (
                `receipt_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` INT(10) UNSIGNED NOT NULL,
                `date` TIMESTAMP NOT NULL,
                `amount` DECIMAL(10,2) UNSIGNED NOT NULL,
                `qr_code` VARCHAR(1000) NOT NULL COLLATE 'utf8mb4_unicode_ci',
                `created` TIMESTAMP NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`receipt_id`),
                INDEX `fk-receipt-user` (`user_id`),
                CONSTRAINT `fk-receipt-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
            )
            COLLATE='utf8mb4_unicode_ci'
            ENGINE=InnoDB");
        }
        if ($this->db->getTableSchema('user_receipt', true) === null) {
            $this->execute("
                CREATE TABLE `user_receipt` (
                    `user_receipt_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `user_id` INT(10) UNSIGNED NOT NULL,
                    `receipt_id` INT(10) UNSIGNED NOT NULL,
                    `status` ENUM('used','unusable','skipped') NOT NULL DEFAULT 'used' COLLATE 'utf8mb4_unicode_ci',
                    `created` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
                    PRIMARY KEY (`user_receipt_id`),
                    INDEX `fk-user_receipt-user` (`user_id`),
                    INDEX `fk-user_receipt-receipt` (`receipt_id`),
                    CONSTRAINT `fk-user_receipt-receipt` FOREIGN KEY (`receipt_id`) REFERENCES `receipt` (`receipt_id`) ON UPDATE CASCADE ON DELETE CASCADE,
                    CONSTRAINT `fk-user_receipt-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
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
        $this->dropTable('user_receipt');
        $this->dropTable('receipt');
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210403_044140_init_app cannot be reverted.\n";

        return false;
    }
    */
}
