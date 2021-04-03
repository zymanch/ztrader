<?php

namespace backend\models\base;



/**
 * This is the model class for table "smoke_tests.test_log".
 *
 * @property integer $test_log_id
 * @property integer $test_id
 * @property integer $response_code
 * @property integer $response_time_ms
 * @property string $response
 * @property string $status
 * @property string $error_message
 * @property string $created
 *
 * @property \backend\models\Test $test
 */
class BaseTestLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smoke_tests.test_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseTestLogPeer::TEST_ID, BaseTestLogPeer::RESPONSE_CODE, BaseTestLogPeer::RESPONSE_TIME_MS, BaseTestLogPeer::RESPONSE, BaseTestLogPeer::STATUS], 'required'],
            [[BaseTestLogPeer::TEST_ID, BaseTestLogPeer::RESPONSE_CODE, BaseTestLogPeer::RESPONSE_TIME_MS], 'integer'],
            [[BaseTestLogPeer::RESPONSE, BaseTestLogPeer::STATUS, BaseTestLogPeer::ERROR_MESSAGE], 'string'],
            [[BaseTestLogPeer::CREATED], 'safe'],
            [[BaseTestLogPeer::TEST_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseTest::className(), 'targetAttribute' => [BaseTestLogPeer::TEST_ID => BaseTestPeer::TEST_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseTestLogPeer::TEST_LOG_ID => 'Test Log ID',
            BaseTestLogPeer::TEST_ID => 'Test ID',
            BaseTestLogPeer::RESPONSE_CODE => 'Response Code',
            BaseTestLogPeer::RESPONSE_TIME_MS => 'Response Time Ms',
            BaseTestLogPeer::RESPONSE => 'Response',
            BaseTestLogPeer::STATUS => 'Status',
            BaseTestLogPeer::ERROR_MESSAGE => 'Error Message',
            BaseTestLogPeer::CREATED => 'Created',
        ];
    }
    /**
     * @return \backend\models\TestQuery
     */
    public function getTest() {
        return $this->hasOne(\backend\models\Test::className(), [BaseTestPeer::TEST_ID => BaseTestLogPeer::TEST_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\TestLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\TestLogQuery(get_called_class());
    }
}
