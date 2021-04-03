<?php

namespace backend\models\base;



/**
 * This is the model class for table "ztrader.user".
 *
 * @property integer $user_id
 * @property string $username
 * @property string $role
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $white_ips
 * @property string $created
 */
class BaseUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ztrader.user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseUserPeer::USERNAME, BaseUserPeer::EMAIL, BaseUserPeer::PASSWORD, BaseUserPeer::AUTH_KEY], 'required'],
            [[BaseUserPeer::ROLE, BaseUserPeer::WHITE_IPS], 'string'],
            [[BaseUserPeer::CREATED], 'safe'],
            [[BaseUserPeer::USERNAME, BaseUserPeer::PASSWORD, BaseUserPeer::AUTH_KEY], 'string', 'max' => 64],
            [[BaseUserPeer::EMAIL], 'string', 'max' => 128],
            [[BaseUserPeer::USERNAME], 'unique'],
            [[BaseUserPeer::EMAIL], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseUserPeer::USER_ID => 'User ID',
            BaseUserPeer::USERNAME => 'Username',
            BaseUserPeer::ROLE => 'Role',
            BaseUserPeer::EMAIL => 'Email',
            BaseUserPeer::PASSWORD => 'Password',
            BaseUserPeer::AUTH_KEY => 'Auth Key',
            BaseUserPeer::WHITE_IPS => 'White Ips',
            BaseUserPeer::CREATED => 'Created',
        ];
    }

    /**
     * @inheritdoc
     * @return \backend\models\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\UserQuery(get_called_class());
    }
}
