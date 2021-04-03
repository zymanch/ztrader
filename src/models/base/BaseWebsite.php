<?php

namespace backend\models\base;



/**
 * This is the model class for table "shared.website".
 *
 * @property integer $website_id
 * @property integer $parent_website_id
 * @property integer $content_id
 * @property string $shortname
 * @property string $shortcode
 * @property string $name
 * @property string $description
 * @property string $url
 * @property string $secret
 * @property string $jwt_secret
 * @property string $engine
 * @property string $url_lan
 * @property string $logo
 * @property string $main_gallery_page
 * @property string $registration_enabled
 * @property string $template_class
 * @property string $delegated_login_enabled
 * @property string $type
 * @property string $is_active
 * @property string $use_by_landing_pages
 * @property string $json_params
 * @property string $constant
 * @property string $watermark
 * @property string $status
 * @property string $support_email
 * @property string $consistency_check
 * @property string $internal_host_name
 *
 * @property \backend\models\Config[] $configs
 * @property \backend\models\Website $parentWebsite
 * @property \backend\models\Website[] $websites
 */
class BaseWebsite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shared.website';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[BaseWebsitePeer::WEBSITE_ID, BaseWebsitePeer::CONTENT_ID, BaseWebsitePeer::NAME, BaseWebsitePeer::DESCRIPTION, BaseWebsitePeer::URL, BaseWebsitePeer::CONSTANT], 'required'],
            [[BaseWebsitePeer::WEBSITE_ID, BaseWebsitePeer::PARENT_WEBSITE_ID, BaseWebsitePeer::CONTENT_ID], 'integer'],
            [[BaseWebsitePeer::ENGINE, BaseWebsitePeer::REGISTRATION_ENABLED, BaseWebsitePeer::DELEGATED_LOGIN_ENABLED, BaseWebsitePeer::TYPE, BaseWebsitePeer::IS_ACTIVE, BaseWebsitePeer::USE_BY_LANDING_PAGES, BaseWebsitePeer::JSON_PARAMS, BaseWebsitePeer::STATUS, BaseWebsitePeer::CONSISTENCY_CHECK], 'string'],
            [[BaseWebsitePeer::SHORTNAME, BaseWebsitePeer::DESCRIPTION, BaseWebsitePeer::MAIN_GALLERY_PAGE, BaseWebsitePeer::TEMPLATE_CLASS, BaseWebsitePeer::CONSTANT, BaseWebsitePeer::WATERMARK], 'string', 'max' => 45],
            [[BaseWebsitePeer::SHORTCODE], 'string', 'max' => 2],
            [[BaseWebsitePeer::NAME], 'string', 'max' => 30],
            [[BaseWebsitePeer::URL], 'string', 'max' => 70],
            [[BaseWebsitePeer::SECRET], 'string', 'max' => 64],
            [[BaseWebsitePeer::JWT_SECRET], 'string', 'max' => 32],
            [[BaseWebsitePeer::URL_LAN], 'string', 'max' => 120],
            [[BaseWebsitePeer::LOGO], 'string', 'max' => 50],
            [[BaseWebsitePeer::SUPPORT_EMAIL], 'string', 'max' => 128],
            [[BaseWebsitePeer::INTERNAL_HOST_NAME], 'string', 'max' => 255],
            [[BaseWebsitePeer::CONSTANT], 'unique'],
            [[BaseWebsitePeer::PARENT_WEBSITE_ID], 'exist', 'skipOnError' => true, 'targetClass' => BaseWebsite::className(), 'targetAttribute' => [BaseWebsitePeer::PARENT_WEBSITE_ID => BaseWebsitePeer::WEBSITE_ID]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            BaseWebsitePeer::WEBSITE_ID => 'Website ID',
            BaseWebsitePeer::PARENT_WEBSITE_ID => 'Parent Website ID',
            BaseWebsitePeer::CONTENT_ID => 'Content ID',
            BaseWebsitePeer::SHORTNAME => 'Shortname',
            BaseWebsitePeer::SHORTCODE => 'Shortcode',
            BaseWebsitePeer::NAME => 'Name',
            BaseWebsitePeer::DESCRIPTION => 'Description',
            BaseWebsitePeer::URL => 'Url',
            BaseWebsitePeer::SECRET => 'Secret',
            BaseWebsitePeer::JWT_SECRET => 'Jwt Secret',
            BaseWebsitePeer::ENGINE => 'Engine',
            BaseWebsitePeer::URL_LAN => 'Url Lan',
            BaseWebsitePeer::LOGO => 'Logo',
            BaseWebsitePeer::MAIN_GALLERY_PAGE => 'Main Gallery Page',
            BaseWebsitePeer::REGISTRATION_ENABLED => 'Registration Enabled',
            BaseWebsitePeer::TEMPLATE_CLASS => 'Template Class',
            BaseWebsitePeer::DELEGATED_LOGIN_ENABLED => 'Delegated Login Enabled',
            BaseWebsitePeer::TYPE => 'Type',
            BaseWebsitePeer::IS_ACTIVE => 'Is Active',
            BaseWebsitePeer::USE_BY_LANDING_PAGES => 'Use By Landing Pages',
            BaseWebsitePeer::JSON_PARAMS => 'Json Params',
            BaseWebsitePeer::CONSTANT => 'Constant',
            BaseWebsitePeer::WATERMARK => 'Watermark',
            BaseWebsitePeer::STATUS => 'Status',
            BaseWebsitePeer::SUPPORT_EMAIL => 'Support Email',
            BaseWebsitePeer::CONSISTENCY_CHECK => 'Consistency Check',
            BaseWebsitePeer::INTERNAL_HOST_NAME => 'Internal Host Name',
        ];
    }
    /**
     * @return \backend\models\ConfigQuery
     */
    public function getConfigs() {
        return $this->hasMany(\backend\models\Config::className(), [BaseConfigPeer::WEBSITE_ID => BaseWebsitePeer::WEBSITE_ID]);
    }
        /**
     * @return \backend\models\WebsiteQuery
     */
    public function getParentWebsite() {
        return $this->hasOne(\backend\models\Website::className(), [BaseWebsitePeer::WEBSITE_ID => BaseWebsitePeer::PARENT_WEBSITE_ID]);
    }
        /**
     * @return \backend\models\WebsiteQuery
     */
    public function getWebsites() {
        return $this->hasMany(\backend\models\Website::className(), [BaseWebsitePeer::PARENT_WEBSITE_ID => BaseWebsitePeer::WEBSITE_ID]);
    }
    
    /**
     * @inheritdoc
     * @return \backend\models\WebsiteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\WebsiteQuery(get_called_class());
    }
}
