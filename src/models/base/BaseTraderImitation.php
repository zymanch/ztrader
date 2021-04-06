<?php

namespace backend\models\base;



/**
 * This is the model class for table "ztrader.trader_imitation".
 *
 * @property integer $trader_imitation_id
 * @property integer $trader_id
 * @property string $from
 * @property string $to
 * @property integer $tick_size
 * @property string $status
 * @property integer $progress
 *
 * @property \backend\models\Trader $trader
 */
class BaseTraderImitation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ztrader.trader_imitation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseTraderImitationPeer::TRADER_ID], 'required'],
            [[BaseTraderImitationPeer::TRADER_ID, BaseTraderImitationPeer::TICK_SIZE, BaseTraderImitationPeer::PROGRESS], 'integer'],
            [[BaseTraderImitationPeer::FROM, BaseTraderImitationPeer::TO], 'safe'],
            [[BaseTraderImitationPeer::STATUS], 'string'],
            [[BaseTraderImitationPeer::TRADER_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseTrader::className(), 'targetAttribute' => [BaseTraderImitationPeer::TRADER_ID => BaseTraderPeer::TRADER_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseTraderImitationPeer::TRADER_IMITATION_ID => 'Trader Imitation ID',
            BaseTraderImitationPeer::TRADER_ID => 'Trader ID',
            BaseTraderImitationPeer::FROM => 'From',
            BaseTraderImitationPeer::TO => 'To',
            BaseTraderImitationPeer::TICK_SIZE => 'Tick Size',
            BaseTraderImitationPeer::STATUS => 'Status',
            BaseTraderImitationPeer::PROGRESS => 'Progress',
        ];
    }
    /**
     * @return \backend\models\TraderQuery
     */
    public function getTrader() {
        return $this->hasOne(\backend\models\Trader::className(), [BaseTraderPeer::TRADER_ID => BaseTraderImitationPeer::TRADER_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\TraderImitationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\TraderImitationQuery(get_called_class());
    }
}
