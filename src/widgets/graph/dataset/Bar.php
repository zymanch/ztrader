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
use backend\traits\ClearArray;
use backend\traits\Create;
use yii\web\JsExpression;

/**
 * to make row clickable, add 'clickable-row' class to rowOptions
*/
class Bar extends Base{

    use Create;

    protected $_borderSkipped;
    protected $_hoverBackgroundColor;
    protected $_hoverBorderColor;
    protected $_hoverBorderWidth;



    public function asDataset() {
        $options = [
            'borderSkipped' => $this->_borderSkipped,
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
        return self::TYPE_BAR;
    }

    /**
     * @return $this
     * @param mixed $borderSkipped
     */
    public function setBorderSkipped($borderSkipped) {
        $this->_borderSkipped = $borderSkipped;
        return $this;
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