<?php

namespace backend\models\base;



/**
 * This is the model class for table "ztrader.user_receipt".
 *
 * @property integer $user_receipt_id
 * @property integer $user_id
 * @property integer $receipt_id
 * @property string $status
 * @property string $created
 *
 * @property \backend\models\Receipt $receipt
 * @property \backend\models\User $user
 */
class BaseUserReceipt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ztrader.user_receipt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseUserReceiptPeer::USER_ID, BaseUserReceiptPeer::RECEIPT_ID], 'required'],
            [[BaseUserReceiptPeer::USER_ID, BaseUserReceiptPeer::RECEIPT_ID], 'integer'],
            [[BaseUserReceiptPeer::STATUS], 'string'],
            [[BaseUserReceiptPeer::CREATED], 'safe'],
            [[BaseUserReceiptPeer::RECEIPT_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseReceipt::className(), 'targetAttribute' => [BaseUserReceiptPeer::RECEIPT_ID => BaseReceiptPeer::RECEIPT_ID]],
            [[BaseUserReceiptPeer::USER_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseUser::className(), 'targetAttribute' => [BaseUserReceiptPeer::USER_ID => BaseUserPeer::USER_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseUserReceiptPeer::USER_RECEIPT_ID => 'User Receipt ID',
            BaseUserReceiptPeer::USER_ID => 'User ID',
            BaseUserReceiptPeer::RECEIPT_ID => 'Receipt ID',
            BaseUserReceiptPeer::STATUS => 'Status',
            BaseUserReceiptPeer::CREATED => 'Created',
        ];
    }
    /**
     * @return \backend\models\ReceiptQuery
     */
    public function getReceipt() {
        return $this->hasOne(\backend\models\Receipt::className(), [BaseReceiptPeer::RECEIPT_ID => BaseUserReceiptPeer::RECEIPT_ID]);
    }
        /**
     * @return \backend\models\UserQuery
     */
    public function getUser() {
        return $this->hasOne(\backend\models\User::className(), [BaseUserPeer::USER_ID => BaseUserReceiptPeer::USER_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\UserReceiptQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\UserReceiptQuery(get_called_class());
    }
}
