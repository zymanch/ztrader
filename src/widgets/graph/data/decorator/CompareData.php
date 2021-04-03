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
class CompareData implements Data {

    use Create;

    protected $_values = [];
    protected $_labels = [];
    protected $_tooltips = [];
    protected $_title;
    protected $_color;


    public function __construct(Data $mainData, Data $secondData) {
        $this->_values = $mainData->getValues();
        $this->_labels = $mainData->getLabels();
        $this->_tooltips = $this->_getMergedTooltips($mainData, $secondData);
    }

    protected function _getMergedTooltips(Data $mainData, Data $secondData) {
        $result = [];
        $secondTooltips = $secondData->getTooltips();
        foreach ($mainData->getTooltips() as $index => $tooltip) {
            $firstValue = $tooltip[1];
            $secondValue = $secondTooltips[$index][1];
            if ($secondValue == 0) {
                $diff = 100;
            } else {
                $diff = 100 * ($firstValue - $secondValue) / abs($secondValue);
            }
            $tooltip[2] = sprintf('%s%01.2f%%', $diff > 0 ? '+' : '', $diff);
            $result[] = $tooltip;
        }
        return $result;
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

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->_title = $title;
        return $this;
    }

    public function getTitle() {
        if ($this->_title) {
            return $this->_title;
        }
        $tooltips = $this->_tooltips;
        $firstTooltip = reset($tooltips);
        $lastTooltip = end($tooltips);
        return sprintf('%s to %s', $firstTooltip[0], $lastTooltip[0]);

    }

    public function getColor() {
        return $this->_color;
    }

}