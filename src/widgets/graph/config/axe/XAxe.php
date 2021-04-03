<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\config\axe;

use backend\traits\ClearArray;
use backend\traits\Create;

class XAxe extends Axe {
    use ClearArray;
    use Create;

    public function init() {
        $this->setAxeOrientation(self::AXE_ORIENTATION_X);
    }

    protected function _getType() {
        return null;
    }

}