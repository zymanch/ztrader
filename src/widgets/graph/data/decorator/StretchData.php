<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\data\decorator;

use app\widgets\graph\contract\Data;
use backend\traits\Create;

/**
 * to make row clickable, add 'clickable-row' class to rowOptions
*/
class StretchData implements Data {

    use Create;

    /** @var Data  */
    protected $_data;

    protected $_labels = [];

    protected $_values = [];

    protected $_tooltips = [];

    protected $_title;

    protected $_color;

    protected $_defaultValue;

    public function __construct(Data $mainData, Data $sourceData) {
        $days = count($sourceData->getLabels());
        $this->_labels = $this->_stretchData($mainData->getLabels(), $days);
        $this->_values = $this->_stretchData($mainData->getValues(), $days);
        $this->_tooltips = $this->_stretchData($mainData->getTooltips(), $days);
        $this->_color = $mainData->getColor();
        $this->_title = $mainData->getTitle();
    }

    protected function _stretchData(array $array, $count, $defaultValue = null) {
        if (count($array) === (int)$count) {
            return $array;
        }
        if (count($array) < $count) {
            return array_merge(
                $array,
                array_fill(0, $count-count($array), $defaultValue)
            );
        }
        return array_splice($array, 0, $count);
    }

    public function getTitle() {
        return $this->_title;
    }

    public function getColor() {
        return $this->_color;
    }

    public function getValues() {
        return $this->_values;
    }

    public function getLabels() {
        return $this->_labels;
    }

    public function getTooltips() {
        return $this->_tooltips;
    }


    public function setTitle($title) {
        $this->_title = $title;
        return $this;
    }

    public function setColor($color) {
        $this->_color = $color;
        return $this;
    }

}