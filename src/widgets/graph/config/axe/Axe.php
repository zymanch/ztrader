<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\config\axe;

use app\widgets\graph\contract\Config;
use backend\traits\ClearArray;
use backend\traits\Create;

abstract class Axe implements Config {

    const AXE_ORIENTATION_X = 'x';
    const AXE_ORIENTATION_Y = 'y';

    use ClearArray;
    use Create;

    protected $_display;
    protected $_stacked;

    protected $_axeOrientation = self::AXE_ORIENTATION_Y;


    public function __construct() {
        $this->init();
    }

    public function init() {

    }

    public function getConfiguration($labels, $datasets) {
        return [
            'scales' => [
                $this->_axeOrientation.'Axes' => [$this->_getConfiguration($labels, $datasets)]
            ]
        ];
    }

    protected function _getConfiguration($labels, $datasets) {
        $axeConfig = [
            'type' => $this->_getType(),
            'display' => $this->_display,
            'stacked' => $this->_stacked
        ];
        return  $this->_clearArray($axeConfig);

    }

    abstract protected function _getType();

    /**
     * @return $this
     */
    public function show() {
        $this->_display = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function hide() {
        $this->_display = false;
        return $this;
    }

    /**
     * @return $this
     * @param string $axeOrientation
     */
    public function setAxeOrientation($axeOrientation) {
        $this->_axeOrientation = $axeOrientation;
        return $this;
    }

    /**
     * @return $this
     */
    public function enableStacked() {
        $this->_stacked = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableStacked() {
        $this->_stacked = false;
        return $this;
    }

}