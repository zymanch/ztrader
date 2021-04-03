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
 * @method static Pie create(Data $data)
*/
class Pie extends Base {

    use Create;

    protected $_hoverBackgroundColor;
    protected $_hoverBorderColor;
    protected $_hoverBorderWidth;

    public function asDataset() {
        $options = [
            'hoverBackgroundColor'   => $this->_hoverBackgroundColor,
            'hoverBorderColor'   => $this->_hoverBorderColor,
            'hoverBorderWidth'   => $this->_hoverBorderWidth,
        ];
        return array_merge(
            parent::asDataset(),
            $this->_clearArray($options)
        );
    }

    public function getType() {
        return self::TYPE_PIE;
    }


    /**
     * @return $this
     * @param mixed $hoverBackgroundColor
     */
    public function setHoverBackgroundColor($hoverBackgroundColor) {
        $this->_hoverBackgroundColor = $hoverBackgroundColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $hoverBorderColor
     */
    public function setHoverBorderColor($hoverBorderColor) {
        $this->_hoverBorderColor = $hoverBorderColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $hoverBorderWidth
     */
    public function setHoverBorderWidth($hoverBorderWidth) {
        $this->_hoverBorderWidth = $hoverBorderWidth;
        return $this;
    }
}