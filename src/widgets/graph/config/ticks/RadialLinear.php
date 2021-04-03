<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\config\ticks;

use app\widgets\graph\contract\Ticks;
use backend\traits\ClearArray;
use backend\traits\Create;

class RadialLinear implements Ticks {

    use ClearArray;
    use Create;

    protected $_backdropColor;
    protected $_backdropPaddingY;
    protected $_backdropPaddingX;
    protected $_showLabelBackdrop;
    private $_beginAtZero;
    private $_min;
    private $_max;
    private $_maxTicksLimit;
    private $_stepSize;
    private $_suggestedMax;
    private $_suggestedMin;

    public function getConfiguration($labels, $datasets) {

        $config = [
            'backdropColor' => $this->_backdropColor,
            'backdropPaddingX' => $this->_backdropPaddingX,
            'backdropPaddingY' => $this->_backdropPaddingY,
            'showLabelBackdrop' => $this->_showLabelBackdrop,
            'beginAtZero' => $this->_beginAtZero,
            'min' => $this->_min,
            'max' => $this->_max,
            'maxTicksLimit' => $this->_maxTicksLimit,
            'stepSize' => $this->_stepSize,
            'suggestedMax' => $this->_suggestedMax,
            'suggestedMin' => $this->_suggestedMin,
        ];
        return $this->_clearArray($config);

    }

    /**
     * @return $this
     * @param mixed $backdropColor
     */
    public function setBackdropColor($backdropColor) {
        $this->_backdropColor = $backdropColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $backdropPaddingY
     */
    public function setBackdropPaddingY($backdropPaddingY) {
        $this->_backdropPaddingY = $backdropPaddingY;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $backdropPaddingX
     */
    public function setBackdropPaddingX($backdropPaddingX) {
        $this->_backdropPaddingX = $backdropPaddingX;
        return $this;
    }

    /**
     * @return $this
     */
    public function enableShowLabelBackdrop() {
        $this->_showLabelBackdrop = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableShowLabelBackdrop() {
        $this->_showLabelBackdrop = false;
        return $this;
    }

    /**
     * @return $this
     */
    public function enableBeginAtZero() {
        $this->_beginAtZero = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableBeginAtZero() {
        $this->_beginAtZero = false;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $min
     */
    public function setMin($min) {
        $this->_min = $min;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $max
     */
    public function setMax($max) {
        $this->_max = $max;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $maxTicksLimit
     */
    public function setMaxTicksLimit($maxTicksLimit) {
        $this->_maxTicksLimit = $maxTicksLimit;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $stepSize
     */
    public function setStepSize($stepSize) {
        $this->_stepSize = $stepSize;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $suggestedMax
     */
    public function setSuggestedMax($suggestedMax) {
        $this->_suggestedMax = $suggestedMax;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $suggestedMin
     */
    public function setSuggestedMin($suggestedMin) {
        $this->_suggestedMin = $suggestedMin;
        return $this;
    }

}