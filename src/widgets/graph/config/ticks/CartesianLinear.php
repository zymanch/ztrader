<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\config\ticks;


class CartesianLinear extends Cartesian{

    protected $_beginAtZero = true;
    protected $_maxTicksLimit;
    protected $_stepSize;
    protected $_suggestedMax;
    protected $_suggestedMin;

    public function init() {
        $this->setMin(0);
    }

    public function getConfiguration($axeId, $labels, $datasets) {

        $config = [
            'beginAtZero' => $this->_beginAtZero,
            'maxTicksLimit' => $this->_maxTicksLimit,
            'stepSize' => $this->_stepSize,
            'suggestedMax' => $this->_suggestedMax,
            'suggestedMin' => $this->_suggestedMin,
        ];
        return  array_merge(
            parent::getConfiguration($axeId, $labels, $datasets),
            $this->_clearArray($config)
        );

    }

    public function enableBeginAtZero() {
        $this->_beginAtZero = true;
        $this->_min = 0;
        return $this;
    }

    public function disableBeginAtZero() {
        $this->_beginAtZero = false;
        return $this;
    }

    /**
     * @param mixed $maxTicksLimit
     * @return $this
     */
    public function setMaxTicksLimit($maxTicksLimit) {
        $this->_maxTicksLimit = $maxTicksLimit;
        return $this;
    }

    /**
     * @param mixed $stepSize
     * @return $this
     */
    public function setStepSize($stepSize) {
        $this->_stepSize = $stepSize;
        return $this;
    }

    /**
     * @param mixed $suggestedMax
     * @return $this
     */
    public function setSuggestedMax($suggestedMax) {
        $this->_suggestedMax = $suggestedMax;
        return $this;
    }

    /**
     * @param mixed $suggestedMin
     * @return $this
     */
    public function setSuggestedMin($suggestedMin) {
        $this->_suggestedMin = $suggestedMin;
        return $this;
    }

}