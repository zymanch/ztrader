<?php

namespace backend\models\base;



/**
 * This is the model class for table "ztrader.buyer".
 *
 * @property integer $buyer_id
 * @property string $type
 * @property string $name
 *
 * @property \backend\models\Trader[] $traders
 */
class BaseBuyer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ztrader.buyer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseBuyerPeer::TYPE, BaseBuyerPeer::NAME], 'required'],
            [[BaseBuyerPeer::TYPE, BaseBuyerPeer::NAME], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseBuyerPeer::BUYER_ID => 'Buyer ID',
            BaseBuyerPeer::TYPE => 'Type',
            BaseBuyerPeer::NAME => 'Name',
        ];
    }
    /**
     * @return \backend\models\TraderQuery
     */
    public function getTraders() {
        return $this->hasMany(\backend\models\Trader::className(), [BaseTraderPeer::BUYER_ID => BaseBuyerPeer::BUYER_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\BuyerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\BuyerQuery(get_called_class());
    }
}
