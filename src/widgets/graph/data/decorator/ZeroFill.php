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
class ZeroFill implements Data {

    use Create;

    protected $_abs = false;

    /** @var Data  */
    protected $_data;

    protected $_labels = [];

    protected $_title;

    protected $_color;

    protected $_defaultValue;

    public function __construct(Data $data, $labels, $defaultValue = 0) {
        $this->_labels = $labels;
        $this->_data = $data;
        $this->_defaultValue = $defaultValue;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function getColor() {
        return $this->_color;
    }

    public function getValues() {
        $result = [];
        $oldData = array_combine(
            $this->_data->getLabels(),
            $this->_data->getValues()
        );
        foreach ($this->_labels as $index => $label) {
            if (isset($oldData[$label])) {
                $value = $oldData[$label];
                if (is_string($value)) {
                    $result[] = strpos($value,'.') ? (float)$value : (int)$value;
                } else {
                    $result[] = $value;
                }
            } else {
                $result[] = $this->_defaultValue;
            }
        }
        return $result;
    }

    public function getLabels() {
        return $this->_labels;
    }

    public function getTooltips() {
        $result = [];
        $oldData = array_combine(
            $this->_data->getLabels(),
            $this->_data->getValues()
        );
        foreach ($this->_labels as $index => $label) {
            $result[] = [
                $label,
                isset($oldData[$label]) ? $oldData[$label] : $this->_defaultValue
            ];
        }
        return $result;
    }

    public function setAbs($abs) {
        $this->_abs = $abs;
        return $this;
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