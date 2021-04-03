<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\data;

use app\widgets\graph\contract\Data as Base;
use backend\traits\Create;

/**
 * to make row clickable, add 'clickable-row' class to rowOptions
*/
class Data implements Base {

    use Create;

    protected $_abs = false;

    protected $_data = [];

    protected $_title;

    protected $_color;
    protected $_labels;
    protected $_tooltips;

    public function __construct($data) {
        $this->_data = $data;
    }


    public function getTitle() {
        return $this->_title;
    }

    public function getColor() {
        return $this->_color;
    }

    public function getValues() {
        $result = array_values($this->_data);
        if ($this->_abs) {
            $result = array_map('abs',$result);
        } else {
            $result = array_map(function($val) {
                if (!is_string($val)) {
                    return $val;
                }
                return strpos($val,'.') ? (float)$val : (int)$val;
            },$result);
        }
        return $result;
    }

    public function getLabels() {
        if ($this->_labels === null) {
            $this->_labels = array_keys($this->_data);
        }
        return $this->_labels;
    }

    /**
     * @param $labels
     * @return $this
     */
    public function setLabels($labels) {
        $this->_labels = $labels;
        return $this;
    }

    public function getTooltips() {
        if ($this->_tooltips!==null) {
            return $this->_tooltips;
        }
        $result = [];
        $labels = $this->getLabels();
        foreach ($this->getValues() as $key => $value) {
            $result[] = [$labels[$key], $value];
        }
        $this->_tooltips = $result;
        return $this->_tooltips;
    }

    /**
     * @param $tooltips
     * @return $this
     */
    public function setTooltips($tooltips) {
        $this->_tooltips = $tooltips;
        return $this;
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