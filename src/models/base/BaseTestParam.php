<?php

namespace backend\models\base;



/**
 * This is the model class for table "smoke_tests.test_param".
 *
 * @property integer $test_param_id
 * @property integer $test_id
 * @property string $name
 * @property string $value
 *
 * @property \backend\models\Test $test
 */
class BaseTestParam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smoke_tests.test_param';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseTestParamPeer::TEST_ID], 'integer'],
            [[BaseTestParamPeer::NAME, BaseTestParamPeer::VALUE], 'required'],
            [[BaseTestParamPeer::NAME], 'string', 'max' => 64],
            [[BaseTestParamPeer::VALUE], 'string', 'max' => 1000],
            [[BaseTestParamPeer::TEST_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseTest::className(), 'targetAttribute' => [BaseTestParamPeer::TEST_ID => BaseTestPeer::TEST_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseTestParamPeer::TEST_PARAM_ID => 'Test Param ID',
            BaseTestParamPeer::TEST_ID => 'Test ID',
            BaseTestParamPeer::NAME => 'Name',
            BaseTestParamPeer::VALUE => 'Value',
        ];
    }
    /**
     * @return \backend\models\TestQuery
     */
    public function getTest() {
        return $this->hasOne(\backend\models\Test::className(), [BaseTestPeer::TEST_ID => BaseTestParamPeer::TEST_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\TestParamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\TestParamQuery(get_called_class());
    }
}
