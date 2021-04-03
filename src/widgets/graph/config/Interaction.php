<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 27.07.2018
 * Time: 14:01
 */

namespace app\widgets\graph\config;


use app\widgets\graph\contract\Config;
use backend\traits\ClearArray;
use backend\traits\Create;

class Interaction implements Config
{
    use Create;
    use ClearArray;

    protected $_mode;
    protected $_isIntersect;

    public function getConfiguration($labels, $datasets)
    {
        $config = [
            'mode' => $this->_mode,
            'intersect' => $this->_isIntersect
        ];
        return ['hover' => $this->_clearArray($config)];
    }



    public function enableIndexHoverEffect()
    {
        $this->_mode = 'index';
        $this->_isIntersect = false;
        return $this;
    }
}