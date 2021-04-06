<?php

namespace backend\models\base;



/**
 * This is the model class for table "ztrader.trader".
 *
 * @property integer $trader_id
 * @property string $name
 * @property integer $buyer_id
 * @property string $buyer_options
 * @property integer $seller_id
 * @property string $seller_options
 * @property string $state
 * @property string $state_date
 * @property string $status
 *
 * @property \backend\models\Buyer $buyer
 * @property \backend\models\Seller $seller
 * @property \backend\models\TraderHistory[] $traderHistories
 * @property \backend\models\TraderImitation[] $traderImitations
 */
class BaseTrader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ztrader.trader';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseTraderPeer::NAME, BaseTraderPeer::BUYER_ID, BaseTraderPeer::SELLER_ID], 'required'],
            [[BaseTraderPeer::BUYER_ID, BaseTraderPeer::SELLER_ID], 'integer'],
            [[BaseTraderPeer::BUYER_OPTIONS, BaseTraderPeer::SELLER_OPTIONS, BaseTraderPeer::STATE, BaseTraderPeer::STATUS], 'string'],
            [[BaseTraderPeer::STATE_DATE], 'safe'],
            [[BaseTraderPeer::NAME], 'string', 'max' => 64],
            [[BaseTraderPeer::BUYER_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseBuyer::className(), 'targetAttribute' => [BaseTraderPeer::BUYER_ID => BaseBuyerPeer::BUYER_ID]],
            [[BaseTraderPeer::SELLER_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseSeller::className(), 'targetAttribute' => [BaseTraderPeer::SELLER_ID => BaseSellerPeer::SELLER_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseTraderPeer::TRADER_ID => 'Trader ID',
            BaseTraderPeer::NAME => 'Name',
            BaseTraderPeer::BUYER_ID => 'Buyer ID',
            BaseTraderPeer::BUYER_OPTIONS => 'Buyer Options',
            BaseTraderPeer::SELLER_ID => 'Seller ID',
            BaseTraderPeer::SELLER_OPTIONS => 'Seller Options',
            BaseTraderPeer::STATE => 'State',
            BaseTraderPeer::STATE_DATE => 'State Date',
            BaseTraderPeer::STATUS => 'Status',
        ];
    }
    /**
     * @return \backend\models\BuyerQuery
     */
    public function getBuyer() {
        return $this->hasOne(\backend\models\Buyer::className(), [BaseBuyerPeer::BUYER_ID => BaseTraderPeer::BUYER_ID]);
    }
        /**
     * @return \backend\models\SellerQuery
     */
    public function getSeller() {
        return $this->hasOne(\backend\models\Seller::className(), [BaseSellerPeer::SELLER_ID => BaseTraderPeer::SELLER_ID]);
    }
        /**
     * @return \backend\models\TraderHistoryQuery
     */
    public function getTraderHistories() {
        return $this->hasMany(\backend\models\TraderHistory::className(), [BaseTraderHistoryPeer::TRADER_ID => BaseTraderPeer::TRADER_ID]);
    }
        /**
     * @return \backend\models\TraderImitationQuery
     */
    public function getTraderImitations() {
        return $this->hasMany(\backend\models\TraderImitation::className(), [BaseTraderImitationPeer::TRADER_ID => BaseTraderPeer::TRADER_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\TraderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\TraderQuery(get_called_class());
    }
}
