<?php

namespace backend\models\base;



/**
 * This is the model class for table "ztrader.currency".
 *
 * @property integer $currency_id
 * @property string $code
 * @property string $name
 * @property integer $position
 * @property string $active
 *
 * @property \backend\models\Trader[] $traders
 */
class BaseCurrency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ztrader.currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseCurrencyPeer::CODE, BaseCurrencyPeer::NAME], 'required'],
            [[BaseCurrencyPeer::POSITION], 'integer'],
            [[BaseCurrencyPeer::ACTIVE], 'string'],
            [[BaseCurrencyPeer::CODE], 'string', 'max' => 3],
            [[BaseCurrencyPeer::NAME], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseCurrencyPeer::CURRENCY_ID => 'Currency ID',
            BaseCurrencyPeer::CODE => 'Code',
            BaseCurrencyPeer::NAME => 'Name',
            BaseCurrencyPeer::POSITION => 'Position',
            BaseCurrencyPeer::ACTIVE => 'Active',
        ];
    }
    /**
     * @return \backend\models\TraderQuery
     */
    public function getTraders() {
        return $this->hasMany(\backend\models\Trader::className(), [BaseTraderPeer::CURRENCY_ID => BaseCurrencyPeer::CURRENCY_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\CurrencyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\CurrencyQuery(get_called_class());
    }
}
