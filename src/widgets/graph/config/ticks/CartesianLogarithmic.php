<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\config\ticks;


class CartesianLogarithmic extends Cartesian {

    public function init() {
        $this->setCallback('function(valuePayload) {
            return valuePayload;
        }');
        $this->setMin(1);
    }

}