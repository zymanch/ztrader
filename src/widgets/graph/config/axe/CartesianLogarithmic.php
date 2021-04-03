<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\config\axe;

use app\widgets\graph\contract\Ticks;
use backend\traits\Create;

class CartesianLogarithmic extends Cartesian {

    use Create;

    public function init() {
        $this->setTicks(\app\widgets\graph\config\ticks\CartesianLogarithmic::create());
    }

    protected function _getConfiguration($labels, $datasets) {
        $max = $this->_getMaxDatasetsValue($datasets);
        $this->setAfterBuildTicks('function(pckBarChart) {
            var tick = 1;
            pckBarChart.ticks = [];
            while (tick < '.$max.') {
                pckBarChart.ticks.push(tick);
                pckBarChart.ticks.push(tick*3);
                tick*=10;
            }
        }');
        return parent::_getConfiguration($labels, $datasets);
    }

    protected function _getMaxDatasetsValue($datasets) {
        $maxValue = 1;
        foreach ($datasets as $dataset) {
            foreach ($dataset['data'] as $value) {
                if ($maxValue < $value) {
                    $maxValue = $value;
                }
            }
        }
        return $maxValue;
    }

    protected function _getType() {
        return 'logarithmic';
    }

    /**
     * @param Ticks $tick
     * @return $this
     */
    public function setTicks(Ticks $tick) {
        $this->_ticks = $tick;
        return $this;
    }

    /**
     * @return Ticks
     */
    public function getTicks() {
        return $this->_ticks;
    }
}