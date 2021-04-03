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
        $this->execute("CREATE TABLE `user` (
            `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(64) NOT NULL,
            `role` SET('admin','user','trader') NOT NULL DEFAULT 'user',
            `email` VARCHAR(128) NOT NULL,
            `password` VARCHAR(64) NOT NULL,
            `auth_key` VARCHAR(64) NOT NULL,
            `white_ips` TEXT NULL DEFAULT NULL,
            `created` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`user_id`),
            UNIQUE INDEX `user-username` (`username`),
            UNIQUE INDEX `user-email` (`email`)
        )
        COLLATE='latin1_swedish_ci'
        ENGINE=InnoDB
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210403_044140_init_app cannot be reverted.\n";

        return false;
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
