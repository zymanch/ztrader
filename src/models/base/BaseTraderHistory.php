<?php

namespace backend\models\base;



/**
 * This is the model class for table "ztrader.trader_history".
 *
 * @property integer $reader_history_id
 * @property integer $trader_id
 * @property string $date
 * @property string $course
 * @property string $comission_percent
 * @property string $action
 * @property string $type
 *
 * @property \backend\models\Trader $trader
 */
class BaseTraderHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ztrader.trader_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseTraderHistoryPeer::TRADER_ID, BaseTraderHistoryPeer::COURSE, BaseTraderHistoryPeer::COMISSION_PERCENT, BaseTraderHistoryPeer::ACTION, BaseTraderHistoryPeer::TYPE], 'required'],
            [[BaseTraderHistoryPeer::TRADER_ID], 'integer'],
            [[BaseTraderHistoryPeer::DATE], 'safe'],
            [[BaseTraderHistoryPeer::COURSE, BaseTraderHistoryPeer::COMISSION_PERCENT], 'number'],
            [[BaseTraderHistoryPeer::ACTION, BaseTraderHistoryPeer::TYPE], 'string'],
            [[BaseTraderHistoryPeer::TRADER_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseTrader::className(), 'targetAttribute' => [BaseTraderHistoryPeer::TRADER_ID => BaseTraderPeer::TRADER_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseTraderHistoryPeer::READER_HISTORY_ID => 'Reader History ID',
            BaseTraderHistoryPeer::TRADER_ID => 'Trader ID',
            BaseTraderHistoryPeer::DATE => 'Date',
            BaseTraderHistoryPeer::COURSE => 'Course',
            BaseTraderHistoryPeer::COMISSION_PERCENT => 'Comission Percent',
            BaseTraderHistoryPeer::ACTION => 'Action',
            BaseTraderHistoryPeer::TYPE => 'Type',
        ];
    }
    /**
     * @return \backend\models\TraderQuery
     */
    public function getTrader() {
        return $this->hasOne(\backend\models\Trader::className(), [BaseTraderPeer::TRADER_ID => BaseTraderHistoryPeer::TRADER_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\TraderHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\TraderHistoryQuery(get_called_class());
    }
}
