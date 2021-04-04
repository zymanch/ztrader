<?php

namespace backend\models\base;



/**
 * This is the model class for table "ztrader.seller".
 *
 * @property integer $seller_id
 * @property string $type
 * @property string $name
 *
 * @property \backend\models\Trader[] $traders
 */
class BaseSeller extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ztrader.seller';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseSellerPeer::TYPE, BaseSellerPeer::NAME], 'required'],
            [[BaseSellerPeer::TYPE, BaseSellerPeer::NAME], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseSellerPeer::SELLER_ID => 'Seller ID',
            BaseSellerPeer::TYPE => 'Type',
            BaseSellerPeer::NAME => 'Name',
        ];
    }
    /**
     * @return \backend\models\TraderQuery
     */
    public function getTraders() {
        return $this->hasMany(\backend\models\Trader::className(), [BaseTraderPeer::SELLER_ID => BaseSellerPeer::SELLER_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\SellerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\SellerQuery(get_called_class());
    }
}
