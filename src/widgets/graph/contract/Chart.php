<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\contract;


/**
 * to make row clickable, add 'clickable-row' class to rowOptions
*/
interface Chart {

    const TYPE_CATEGORY    = 'category';
    const TYPE_LINEAR      = 'linear';
    const TYPE_LOGARITHMIC = 'logarithmic';
    const TYPE_TIME        = 'time';

    const POSITION_LEFT = 'left';
    const POSITION_RIGHT = 'right';


    public function getType();

    public function modify(&$labels, &$datasets, &$options);

}