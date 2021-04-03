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
class SelfCompareData implements Data {

    use Create;

    const DEFAULT_COMPARE_DAYS = 7;

    protected $_values = [];
    protected $_labels = [];
    protected $_tooltips = [];
    protected $_title;
    protected $_color;


    public function __construct(Data $data, $compareDays = self::DEFAULT_COMPARE_DAYS) {
        $this->_color = $data->getColor();
        $this->_title = $data->getTitle();
        $this->_values = $data->getValues();
        $this->_labels = $data->getLabels();
        $this->_tooltips = $this->_getComparedTooltips($data, $compareDays);
    }

    protected function _getComparedTooltips(Data $data, $compareDays) {
        $result = [];
        $tooltips = $data->getTooltips();
        foreach ($tooltips as $index => $tooltip) {
            $firstValue = $tooltip[1];
            if (isset($tooltips[$index-$compareDays])) {
                $secondValue = $tooltips[$index-$compareDays][1];
                if ($secondValue == 0) {
                    $diff = 100;
                } else {
                    $diff = 100 * ($firstValue - $secondValue) / abs($secondValue);
                }
                $tooltip[2] = sprintf('%s%01.2f%%', $diff > 0 ? '+' : '', $diff);
            }
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

    public function getTitle() {
        return $this->_title;

    }

    public function getColor() {
        return $this->_color;
    }

}