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
interface Dataset {

    const TYPE_LINE = 'line';
    const TYPE_DOUGHNUT = 'doughnut';
    const TYPE_BAR = 'bar';
    const TYPE_RADAR = 'radar';
    const TYPE_PIE = 'pie';
    const TYPE_POLAR_AREA = 'polarArea';
    const TYPE_BUBBLE = 'bubble';

    /**
     * @return Data
     */
    public function getData();

    public function asDataset();

    public function getLabels();

    public function getType();

}