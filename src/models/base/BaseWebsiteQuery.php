<?php

namespace backend\models\base;
use ActiveGenerator\Criteria;
use backend\models\WebsiteQuery;

/**
 * This is the ActiveQuery class for [[backend\models\Website]].
 * @method WebsiteQuery filterByWebsiteId($value, $criteria = null)
 * @method WebsiteQuery filterByParentWebsiteId($value, $criteria = null)
 * @method WebsiteQuery filterByContentId($value, $criteria = null)
 * @method WebsiteQuery filterByShortname($value, $criteria = null)
 * @method WebsiteQuery filterByShortcode($value, $criteria = null)
 * @method WebsiteQuery filterByName($value, $criteria = null)
 * @method WebsiteQuery filterByDescription($value, $criteria = null)
 * @method WebsiteQuery filterByUrl($value, $criteria = null)
 * @method WebsiteQuery filterBySecret($value, $criteria = null)
 * @method WebsiteQuery filterByJwtSecret($value, $criteria = null)
 * @method WebsiteQuery filterByEngine($value, $criteria = null)
 * @method WebsiteQuery filterByUrlLan($value, $criteria = null)
 * @method WebsiteQuery filterByLogo($value, $criteria = null)
 * @method WebsiteQuery filterByMainGalleryPage($value, $criteria = null)
 * @method WebsiteQuery filterByRegistrationEnabled($value, $criteria = null)
 * @method WebsiteQuery filterByTemplateClass($value, $criteria = null)
 * @method WebsiteQuery filterByDelegatedLoginEnabled($value, $criteria = null)
 * @method WebsiteQuery filterByType($value, $criteria = null)
 * @method WebsiteQuery filterByIsActive($value, $criteria = null)
 * @method WebsiteQuery filterByUseByLandingPages($value, $criteria = null)
 * @method WebsiteQuery filterByJsonParams($value, $criteria = null)
 * @method WebsiteQuery filterByConstant($value, $criteria = null)
 * @method WebsiteQuery filterByWatermark($value, $criteria = null)
 * @method WebsiteQuery filterByStatus($value, $criteria = null)
 * @method WebsiteQuery filterBySupportEmail($value, $criteria = null)
 * @method WebsiteQuery filterByConsistencyCheck($value, $criteria = null)
 * @method WebsiteQuery filterByInternalHostName($value, $criteria = null)
  * @method WebsiteQuery orderByWebsiteId($order = Criteria::ASC)
  * @method WebsiteQuery orderByParentWebsiteId($order = Criteria::ASC)
  * @method WebsiteQuery orderByContentId($order = Criteria::ASC)
  * @method WebsiteQuery orderByShortname($order = Criteria::ASC)
  * @method WebsiteQuery orderByShortcode($order = Criteria::ASC)
  * @method WebsiteQuery orderByName($order = Criteria::ASC)
  * @method WebsiteQuery orderByDescription($order = Criteria::ASC)
  * @method WebsiteQuery orderByUrl($order = Criteria::ASC)
  * @method WebsiteQuery orderBySecret($order = Criteria::ASC)
  * @method WebsiteQuery orderByJwtSecret($order = Criteria::ASC)
  * @method WebsiteQuery orderByEngine($order = Criteria::ASC)
  * @method WebsiteQuery orderByUrlLan($order = Criteria::ASC)
  * @method WebsiteQuery orderByLogo($order = Criteria::ASC)
  * @method WebsiteQuery orderByMainGalleryPage($order = Criteria::ASC)
  * @method WebsiteQuery orderByRegistrationEnabled($order = Criteria::ASC)
  * @method WebsiteQuery orderByTemplateClass($order = Criteria::ASC)
  * @method WebsiteQuery orderByDelegatedLoginEnabled($order = Criteria::ASC)
  * @method WebsiteQuery orderByType($order = Criteria::ASC)
  * @method WebsiteQuery orderByIsActive($order = Criteria::ASC)
  * @method WebsiteQuery orderByUseByLandingPages($order = Criteria::ASC)
  * @method WebsiteQuery orderByJsonParams($order = Criteria::ASC)
  * @method WebsiteQuery orderByConstant($order = Criteria::ASC)
  * @method WebsiteQuery orderByWatermark($order = Criteria::ASC)
  * @method WebsiteQuery orderByStatus($order = Criteria::ASC)
  * @method WebsiteQuery orderBySupportEmail($order = Criteria::ASC)
  * @method WebsiteQuery orderByConsistencyCheck($order = Criteria::ASC)
  * @method WebsiteQuery orderByInternalHostName($order = Criteria::ASC)
  * @method WebsiteQuery withConfigs($params = [])
  * @method WebsiteQuery joinWithConfigs($params = null, $joinType = 'LEFT JOIN')
  * @method WebsiteQuery withParentWebsite($params = [])
  * @method WebsiteQuery joinWithParentWebsite($params = null, $joinType = 'LEFT JOIN')
  * @method WebsiteQuery withWebsites($params = [])
  * @method WebsiteQuery joinWithWebsites($params = null, $joinType = 'LEFT JOIN')
 */
class BaseWebsiteQuery extends \yii\db\ActiveQuery
{


    use \ActiveGenerator\base\RichActiveMethods;

    /**
     * @inheritdoc
     * @return \backend\models\Website[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\Website|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \backend\models\WebsiteQuery     */
    public static function model()
    {
        return new \backend\models\WebsiteQuery(\backend\models\Website::class);
    }
}
