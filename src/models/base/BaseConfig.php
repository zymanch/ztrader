<?php

namespace backend\models\base;



/**
 * This is the model class for table "shared.config".
 *
 * @property integer $config_id
 * @property integer $website_id
 * @property string $constant
 * @property string $value
 * @property string $description
 *
 * @property \backend\models\Website $website
 */
class BaseConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shared.config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseConfigPeer::WEBSITE_ID], 'integer'],
            [[BaseConfigPeer::CONSTANT, BaseConfigPeer::VALUE, BaseConfigPeer::DESCRIPTION], 'required'],
            [[BaseConfigPeer::CONSTANT], 'string', 'max' => 50],
            [[BaseConfigPeer::VALUE], 'string', 'max' => 1000],
            [[BaseConfigPeer::DESCRIPTION], 'string', 'max' => 500],
            [[BaseConfigPeer::WEBSITE_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseWebsite::className(), 'targetAttribute' => [BaseConfigPeer::WEBSITE_ID => BaseWebsitePeer::WEBSITE_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseConfigPeer::CONFIG_ID => 'Config ID',
            BaseConfigPeer::WEBSITE_ID => 'Website ID',
            BaseConfigPeer::CONSTANT => 'Constant',
            BaseConfigPeer::VALUE => 'Value',
            BaseConfigPeer::DESCRIPTION => 'Description',
        ];
    }
    /**
     * @return \backend\models\WebsiteQuery
     */
    public function getWebsite() {
        return $this->hasOne(\backend\models\Website::className(), [BaseWebsitePeer::WEBSITE_ID => BaseConfigPeer::WEBSITE_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\ConfigQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\ConfigQuery(get_called_class());
    }
}
