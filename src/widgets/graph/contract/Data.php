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
interface Data {

    public function getTitle();

    public function getColor();

    public function getValues();

    public function getLabels();

    public function getTooltips();

}