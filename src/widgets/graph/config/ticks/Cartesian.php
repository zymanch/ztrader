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
use yii\web\JsExpression;

abstract class Cartesian implements Ticks {

    use Create;
    use ClearArray;

    protected $_scale;
    protected $_min;
    protected $_max;
    protected $_isAutoSkip;
    protected $_autoSkipPadding;
    protected $_labelOffset;
    protected $_maxRotation;
    protected $_minRotation;
    protected $_isMirror;
    protected $_padding;
    protected $_callback;

    public function __construct() {
        $this->init();
    }

    public function init() {

    }

    public function getConfiguration($axeId, $labels, $datasets) {

        $axeConfig = [
            'min' => $this->_min,
            'max' => $this->_getMaxYForArea($axeId, $datasets),
            'autoSkip' => $this->_isAutoSkip,
            'autoSkipPadding' => $this->_autoSkipPadding,
            'labelOffset' => $this->_labelOffset,
            'maxRotation' => $this->_maxRotation,
            'minRotation' => $this->_minRotation,
            'mirror' => $this->_isMirror,
            'padding' => $this->_padding,
            'callback' => $this->_callback,
        ];
        return  $this->_clearArray($axeConfig);

    }

    protected function _getMaxYForArea($axeId, $datasets) {
        if ($this->_max) {
            return $this->_max;
        }
        if (!$this->_scale) {
            return null;
        }
        $max = 0;
        foreach ($datasets as $dataset) {
            if (isset($dataset['yAxisID']) && $dataset['yAxisID'] === $axeId) {
                $max = max(
                    $max,
                    count($dataset['data']) > 1 ? max(...$dataset['data']) : reset($dataset['data'])
                );
            }
        }
        return $this->_scale * $max;
    }

    /**
     * @return mixed
     */
    public function getScale()
    {
        return $this->_scale;
    }


    public function setScale($scale) {
        $this->_scale = $scale;
        return $this;
    }

    public function setMax($max) {
        $this->_max = $max;
        return $max;
    }

    public function setMin($min) {
        $this->_min = $min;
        return $this;
    }

    /**
     * @return $this
     */
    public function enableAutoSkip() {
        $this->_isAutoSkip = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableAutoSkip() {
        $this->_isAutoSkip = false;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $autoSkipPadding
     */
    public function setAutoSkipPadding($autoSkipPadding) {
        $this->_autoSkipPadding = $autoSkipPadding;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $labelOffset
     */
    public function setLabelOffset($labelOffset) {
        $this->_labelOffset = $labelOffset;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $maxRotation
     */
    public function setMaxRotation($maxRotation) {
        $this->_maxRotation = $maxRotation;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $minRotation
     */
    public function setMinRotation($minRotation) {
        $this->_minRotation = $minRotation;
        return $this;
    }

    /**
     * @return $this
     */
    public function enableMirror() {
        $this->_isMirror = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableMirror() {
        $this->_isMirror = false;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $padding
     */
    public function setPadding($padding) {
        $this->_padding = $padding;
        return $this;
    }

    /**
     * @param $callback
     * @return $this
     */
    public function setCallback($callback) {
        $this->_callback = new JsExpression($callback);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallback() {
        return $this->_callback;
    }

    public function setLogarithmicScale($chartMax, $lineMax)
    {
        $scale = (int)(round(log10($chartMax)) - round(log10($lineMax))) + 1;
        $this->setScale($scale <= 0 ? 1 : $scale);
        return $this;
    }


    public function setAdoptiveScale($allMaxes, $lineMax)
    {
        if(count($allMaxes) <= 2){
            $this->setScale(1);
        }

        // Sort maxes to be able to distribution metrics by graph from min at the bottom of the graph to the max at the top
        // The scale will be calculated by position of max in the array
        // example: [ 0 => 1234342, 1 => 11223, 2 => 2323, 3 => 111, 4 => 1]
        $maxes = $allMaxes;
        rsort($maxes);

        // pre calculate scales with "steps" for all "maxes" to get right position on the graph
        // scales example for 5 metrics: [ 0 => 1, 1 => 1.4, 2 => 1.8, 3 => 2.2, 4 => 2.6 ]
        $step = ((count($allMaxes) - 2) / count($allMaxes)) - 0.2; // 0.2 value was determined via tests to provide better metrics distribution
        $scales = [];
        foreach($maxes as $key => $value){
            $scales[ $key ] = $step * $key + 1;
        }

        // Set current max scale from pre_calculated scales
        $maxKey = array_search($lineMax, $maxes, true);
        $this->setScale($scales[$maxKey]);

        return $this;
    }
}