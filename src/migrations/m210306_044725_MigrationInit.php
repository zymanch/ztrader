<?php

use yii\db\Migration;

/**
 * Class m210306_044725_MigrationInit
 */
class m210306_044725_MigrationInit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE TABLE smoke_tests.`smoke_test` (
            `smoke_test_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `application` VARCHAR(45) NOT NULL,
            `engine` ENUM("rest","api","controller") NULL DEFAULT "api",
            `name` VARCHAR(100) NULL DEFAULT NULL,
            `method` ENUM("GET","POST","PUT","OPTIONS","DELETE") NOT NULL DEFAULT "GET",
            `url` VARCHAR(600) NOT NULL DEFAULT "",
            `request_data` TEXT NOT NULL DEFAULT "",
            `check_period_minutes` SMALLINT(6) NOT NULL DEFAULT 60,
            `expected_response_code` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 200,
            `response_code` SMALLINT(6) UNSIGNED NOT NULL,
            `max_execution_time_ms` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 500,
            `response_time_ms` MEDIUMINT(8) UNSIGNED NULL DEFAULT NULL,
            `memory_usage_mb` SMALLINT(6) UNSIGNED NULL DEFAULT NULL,
            `total_execution_count` SMALLINT(6) NOT NULL DEFAULT 0,
            `total_execution_time` INT(11) UNSIGNED NOT NULL DEFAULT 0,
            `response_data_check_strategy` ENUM("none","equal","contains","json_property_equal") NOT NULL DEFAULT "none",
            `response_data_check` TEXT NULL DEFAULT NULL,
            `response` TEXT NULL DEFAULT NULL,
            `enabled` ENUM("yes","no") NOT NULL DEFAULT "yes",
            `status` ENUM("ok","error") NOT NULL DEFAULT "ok",
            `error_message` TEXT NULL DEFAULT NULL,
            `last_checked` TIMESTAMP NULL DEFAULT NULL,
            `created` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
            `hash` VARCHAR(12) NULL DEFAULT NULL,
            PRIMARY KEY (`smoke_test_id`),
            INDEX `enabled` (`enabled`, `check_period_minutes`, `last_checked`),
            INDEX `application` (`application`, `enabled`),
            INDEX `url` (`url`, `enabled`)
        )
        COLLATE="utf8_general_ci"
        ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210306_044725_MigrationInit cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210306_044725_MigrationInit cannot be reverted.\n";

        return false;
    }
    */
}
