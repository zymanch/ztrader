<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\config\ticks;


class CartesianCategory extends Cartesian{

    protected $_labels;

    public function getConfiguration($axeId, $labels, $datasets) {
        $config = [
            'labels' => $this->_labels,
        ];
        return array_merge(
            parent::getConfiguration($axeId, $labels, $datasets),
            $this->_clearArray($config)
        );
    }

    public function setLabels(array $labels) {
        $this->_labels = $labels;
        return $this;
    }


}