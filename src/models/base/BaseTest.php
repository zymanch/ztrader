<?php

namespace backend\models\base;



/**
 * This is the model class for table "smoke_tests.test".
 *
 * @property integer $test_id
 * @property string $application
 * @property string $engine
 * @property string $name
 * @property string $method
 * @property string $url
 * @property string $request_data
 * @property integer $check_period_minutes
 * @property integer $expected_response_code
 * @property integer $response_code
 * @property integer $max_execution_time_ms
 * @property integer $response_time_ms
 * @property integer $memory_usage_mb
 * @property integer $total_execution_count
 * @property integer $total_execution_time
 * @property string $response_data_check_strategy
 * @property string $response_data_check
 * @property string $response
 * @property string $enabled
 * @property string $status
 * @property string $error_message
 * @property string $last_checked
 * @property string $created
 * @property string $hash
 *
 * @property \backend\models\TestLog[] $testLogs
 * @property \backend\models\TestParam[] $testParams
 */
class BaseTest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smoke_tests.test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseTestPeer::APPLICATION, BaseTestPeer::RESPONSE_CODE], 'required'],
            [[BaseTestPeer::ENGINE, BaseTestPeer::METHOD, BaseTestPeer::REQUEST_DATA, BaseTestPeer::RESPONSE_DATA_CHECK_STRATEGY, BaseTestPeer::RESPONSE_DATA_CHECK, BaseTestPeer::RESPONSE, BaseTestPeer::ENABLED, BaseTestPeer::STATUS, BaseTestPeer::ERROR_MESSAGE], 'string'],
            [[BaseTestPeer::CHECK_PERIOD_MINUTES, BaseTestPeer::EXPECTED_RESPONSE_CODE, BaseTestPeer::RESPONSE_CODE, BaseTestPeer::MAX_EXECUTION_TIME_MS, BaseTestPeer::RESPONSE_TIME_MS, BaseTestPeer::MEMORY_USAGE_MB, BaseTestPeer::TOTAL_EXECUTION_COUNT, BaseTestPeer::TOTAL_EXECUTION_TIME], 'integer'],
            [[BaseTestPeer::LAST_CHECKED, BaseTestPeer::CREATED], 'safe'],
            [[BaseTestPeer::APPLICATION], 'string', 'max' => 45],
            [[BaseTestPeer::NAME], 'string', 'max' => 100],
            [[BaseTestPeer::URL], 'string', 'max' => 600],
            [[BaseTestPeer::HASH], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseTestPeer::TEST_ID => 'Test ID',
            BaseTestPeer::APPLICATION => 'Application',
            BaseTestPeer::ENGINE => 'Engine',
            BaseTestPeer::NAME => 'Name',
            BaseTestPeer::METHOD => 'Method',
            BaseTestPeer::URL => 'Url',
            BaseTestPeer::REQUEST_DATA => 'Request Data',
            BaseTestPeer::CHECK_PERIOD_MINUTES => 'Check Period Minutes',
            BaseTestPeer::EXPECTED_RESPONSE_CODE => 'Expected Response Code',
            BaseTestPeer::RESPONSE_CODE => 'Response Code',
            BaseTestPeer::MAX_EXECUTION_TIME_MS => 'Max Execution Time Ms',
            BaseTestPeer::RESPONSE_TIME_MS => 'Response Time Ms',
            BaseTestPeer::MEMORY_USAGE_MB => 'Memory Usage Mb',
            BaseTestPeer::TOTAL_EXECUTION_COUNT => 'Total Execution Count',
            BaseTestPeer::TOTAL_EXECUTION_TIME => 'Total Execution Time',
            BaseTestPeer::RESPONSE_DATA_CHECK_STRATEGY => 'Response Data Check Strategy',
            BaseTestPeer::RESPONSE_DATA_CHECK => 'Response Data Check',
            BaseTestPeer::RESPONSE => 'Response',
            BaseTestPeer::ENABLED => 'Enabled',
            BaseTestPeer::STATUS => 'Status',
            BaseTestPeer::ERROR_MESSAGE => 'Error Message',
            BaseTestPeer::LAST_CHECKED => 'Last Checked',
            BaseTestPeer::CREATED => 'Created',
            BaseTestPeer::HASH => 'Hash',
        ];
    }
    /**
     * @return \backend\models\TestLogQuery
     */
    public function getTestLogs() {
        return $this->hasMany(\backend\models\TestLog::className(), [BaseTestLogPeer::TEST_ID => BaseTestPeer::TEST_ID]);
    }
        /**
     * @return \backend\models\TestParamQuery
     */
    public function getTestParams() {
        return $this->hasMany(\backend\models\TestParam::className(), [BaseTestParamPeer::TEST_ID => BaseTestPeer::TEST_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\TestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\TestQuery(get_called_class());
    }
}
