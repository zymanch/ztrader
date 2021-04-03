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

class CartesianCategory extends Cartesian {

    use Create;

    public function init() {
        $this->setTicks(\app\widgets\graph\config\ticks\CartesianCategory::create());
    }

    protected function _getType() {
        return 'category';
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