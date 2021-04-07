<?php

namespace backend\models\base;



/**
 * This is the model class for table "ztrader.trader_history".
 *
 * @property integer $trader_history_id
 * @property integer $trader_id
 * @property integer $trader_imitation_id
 * @property integer $buy_trader_history_id
 * @property string $date
 * @property string $course
 * @property string $comission_percent
 * @property string $action
 * @property string $type
 *
 * @property \backend\models\Trader $trader
 * @property \backend\models\TraderHistory $buyTraderHistory
 * @property \backend\models\TraderHistory[] $traderHistories
 * @property \backend\models\TraderImitation $traderImitation
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
            [[BaseTraderHistoryPeer::TRADER_ID, BaseTraderHistoryPeer::DATE, BaseTraderHistoryPeer::COURSE, BaseTraderHistoryPeer::COMISSION_PERCENT, BaseTraderHistoryPeer::ACTION, BaseTraderHistoryPeer::TYPE], 'required'],
            [[BaseTraderHistoryPeer::TRADER_ID, BaseTraderHistoryPeer::TRADER_IMITATION_ID, BaseTraderHistoryPeer::BUY_TRADER_HISTORY_ID], 'integer'],
            [[BaseTraderHistoryPeer::DATE], 'safe'],
            [[BaseTraderHistoryPeer::COURSE, BaseTraderHistoryPeer::COMISSION_PERCENT], 'number'],
            [[BaseTraderHistoryPeer::ACTION, BaseTraderHistoryPeer::TYPE], 'string'],
            [[BaseTraderHistoryPeer::TRADER_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseTrader::className(), 'targetAttribute' => [BaseTraderHistoryPeer::TRADER_ID => BaseTraderPeer::TRADER_ID]],
            [[BaseTraderHistoryPeer::BUY_TRADER_HISTORY_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseTraderHistory::className(), 'targetAttribute' => [BaseTraderHistoryPeer::BUY_TRADER_HISTORY_ID => BaseTraderHistoryPeer::TRADER_HISTORY_ID]],
            [[BaseTraderHistoryPeer::TRADER_IMITATION_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseTraderImitation::className(), 'targetAttribute' => [BaseTraderHistoryPeer::TRADER_IMITATION_ID => BaseTraderImitationPeer::TRADER_IMITATION_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseTraderHistoryPeer::TRADER_HISTORY_ID => 'Trader History ID',
            BaseTraderHistoryPeer::TRADER_ID => 'Trader ID',
            BaseTraderHistoryPeer::TRADER_IMITATION_ID => 'Trader Imitation ID',
            BaseTraderHistoryPeer::BUY_TRADER_HISTORY_ID => 'Buy Trader History ID',
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
     * @return \backend\models\TraderHistoryQuery
     */
    public function getBuyTraderHistory() {
        return $this->hasOne(\backend\models\TraderHistory::className(), [BaseTraderHistoryPeer::TRADER_HISTORY_ID => BaseTraderHistoryPeer::BUY_TRADER_HISTORY_ID]);
    }
        /**
     * @return \backend\models\TraderHistoryQuery
     */
    public function getTraderHistories() {
        return $this->hasMany(\backend\models\TraderHistory::className(), [BaseTraderHistoryPeer::BUY_TRADER_HISTORY_ID => BaseTraderHistoryPeer::TRADER_HISTORY_ID]);
    }
        /**
     * @return \backend\models\TraderImitationQuery
     */
    public function getTraderImitation() {
        return $this->hasOne(\backend\models\TraderImitation::className(), [BaseTraderImitationPeer::TRADER_IMITATION_ID => BaseTraderHistoryPeer::TRADER_IMITATION_ID]);
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
