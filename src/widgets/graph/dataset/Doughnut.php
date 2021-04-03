<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\dataset;

use app\widgets\graph\contract\Data;
use app\widgets\graph\contract\Dataset;
use backend\traits\Create;

/**
 * to make row clickable, add 'clickable-row' class to rowOptions
*/
class Doughnut extends Pie {

    use Create;

    public function getType() {
        return self::TYPE_DOUGHNUT;
    }
}