<?php

namespace backend\models\base;



/**
 * This is the model class for table "ztrader.receipt".
 *
 * @property integer $receipt_id
 * @property integer $user_id
 * @property string $date
 * @property string $amount
 * @property string $qr_code
 * @property string $created
 *
 * @property \backend\models\User $user
 * @property \backend\models\UserReceipt[] $userReceipts
 */
class BaseReceipt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ztrader.receipt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseReceiptPeer::USER_ID, BaseReceiptPeer::DATE, BaseReceiptPeer::AMOUNT, BaseReceiptPeer::QR_CODE], 'required'],
            [[BaseReceiptPeer::USER_ID], 'integer'],
            [[BaseReceiptPeer::DATE, BaseReceiptPeer::CREATED], 'safe'],
            [[BaseReceiptPeer::AMOUNT], 'number'],
            [[BaseReceiptPeer::QR_CODE], 'string', 'max' => 1000],
            [[BaseReceiptPeer::USER_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseUser::className(), 'targetAttribute' => [BaseReceiptPeer::USER_ID => BaseUserPeer::USER_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseReceiptPeer::RECEIPT_ID => 'Receipt ID',
            BaseReceiptPeer::USER_ID => 'User ID',
            BaseReceiptPeer::DATE => 'Date',
            BaseReceiptPeer::AMOUNT => 'Amount',
            BaseReceiptPeer::QR_CODE => 'Qr Code',
            BaseReceiptPeer::CREATED => 'Created',
        ];
    }
    /**
     * @return \backend\models\UserQuery
     */
    public function getUser() {
        return $this->hasOne(\backend\models\User::className(), [BaseUserPeer::USER_ID => BaseReceiptPeer::USER_ID]);
    }
        /**
     * @return \backend\models\UserReceiptQuery
     */
    public function getUserReceipts() {
        return $this->hasMany(\backend\models\UserReceipt::className(), [BaseUserReceiptPeer::RECEIPT_ID => BaseReceiptPeer::RECEIPT_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\ReceiptQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\ReceiptQuery(get_called_class());
    }
}
