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
class CallbackData implements Data {

    use Create;

    /** @var Data  */
    protected $_data;

    protected $_callback;

    public function __construct(Data $mainData, $callback) {
        $this->_data = $mainData;
        $this->_callback = $callback;
    }

    public function getTitle() {
        return $this->_data->getTitle();
    }

    public function getColor() {
        return $this->_data->getColor();
    }

    public function getValues() {
        $values = $this->_data->getValues();
        $callback = $this->_callback;
        foreach ($values as $index => $value) {
            $values[$index] = $callback($value);
        }
        return $values;
    }

    public function getLabels() {
        return $this->_data->getLabels();
    }

    public function getTooltips() {
        return $this->_data->getTooltips();
    }

}