<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 13:55
 */

namespace app\extensions\yii\data;

use app\extensions\yii\helpers\Html;
use yii\base\InvalidConfigException;
use yii\data\Sort as YiiDataSort;
use yii\helpers\Inflector;

class Sort extends YiiDataSort
{

    public $sortLinkClass = 'non-styled-sort';

    /**
     * Generates a hyperlink that links to the sort action to sort by the specified attribute.
     * Based on the sort direction, the CSS class of the generated hyperlink will be appended
     * with "asc" or "desc".
     * @param string $attribute the attribute name by which the data should be sorted by.
     * @param array $options additional HTML attributes for the hyperlink tag.
     * There is one special attribute `label` which will be used as the label of the hyperlink.
     * If this is not set, the label defined in [[attributes]] will be used.
     * If no label is defined, [[\yii\helpers\Inflector::camel2words()]] will be called to get a label.
     * Note that it will not be HTML-encoded.
     * @return string the generated hyperlink
     * @throws InvalidConfigException if the attribute is unknown
     */
    public function link($attribute, $options = [])
    {
        if($this->sortLinkClass){
            if (isset($options['class'])) {
                $options['class'] .= ' ' . $this->sortLinkClass;
            } else {
                $options['class'] = $this->sortLinkClass;
            }
        }

        if (($direction = $this->getAttributeOrder($attribute)) !== null) {
            $class = $direction === SORT_DESC ? 'desc' : 'asc';
            if (isset($options['class'])) {
                $options['class'] .= ' ' . $class;
            } else {
                $options['class'] = $class;
            }
        }

        $url = $this->createUrl($attribute);
        $options['data-sort'] = $this->createSortParam($attribute);

        if (isset($options['label'])) {
            $label = $options['label'];
            unset($options['label']);
        } else {
            if (isset($this->attributes[$attribute]['label'])) {
                $label = $this->attributes[$attribute]['label'];
            } else {
                $label = Inflector::camel2words($attribute);
            }
        }

        $sortIcon = Html::tag('span', '', ['class' => 'inspinia-footable-sort-indicator']);

        return Html::a($label, $url, $options) . $sortIcon;
    }

}