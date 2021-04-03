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
abstract class Base implements Dataset{


    use ClearArray;


    /** @var Data  */
    protected $_data;


    protected $_xAxisID;
    protected $_yAxisID;
    protected $_color;
    protected $_backgroundColor;
    protected $_borderColor;
    protected $_borderWidth;
    protected $_tooltipFormat = '{name}: {value}';
    protected $_tooltipCallback;
    protected $_hidden = false;

    protected $_additional = [];

    
    public function __construct(Data $data){
        $this->_data = $data;
    }

    /**
     * @return Data
     */
    public function getData() {
        return $this->_data;
    }


    public function asDataset() {
        $options = [
            'label' => $this->_data->getTitle(),
            'xAxisID' => $this->_xAxisID,
            'yAxisID' => $this->_yAxisID,
            'backgroundColor' => $this->_backgroundColor ? $this->_backgroundColor : ($this->_color ? $this->_color : $this->_data->getColor()),
            'borderColor' => $this->_borderColor ? $this->_borderColor : ($this->_color ? $this->_color : $this->_data->getColor()),
            'borderWidth' => $this->_borderWidth,
            'data'              => $this->_data->getValues(),
            'tooltip'           => $this->_data->getTooltips(),
            'tooltipFormat'     => $this->_tooltipFormat,
            'tooltipCallback'   => $this->_tooltipCallback,
            'hidden'            => $this->_hidden
        ];
        return $this->_clearArray(array_merge($options, $this->_additional));
    }

    /**
     * @return mixed
     */
    public function getLabels() {
        return $this->_data->getLabels();
    }

    /**
     * @param $color
     * @return $this
     */
    public function setColor($color) {
        $this->_color = $color;
        return $this;
    }

    /**
     * @param $backgroundColor
     * @return $this
     */
    public function setBackgroundColor($backgroundColor) {
        $this->_backgroundColor = $backgroundColor;
        return $this;
    }

    /**
     * @param $borderColor
     * @return $this
     */
    public function setBorderColor($borderColor) {
        $this->_borderColor = $borderColor;
        return $this;
    }

    /**
     * @param $borderWidth
     * @return $this
     */
    public function setBorderWidth($borderWidth) {
        $this->_borderWidth = $borderWidth;
        return $this;
    }

    /**
     * @param $tooltipFormat
     * @return $this
     */
    public function setTooltipFormat($tooltipFormat) {
        $this->_tooltipFormat = $tooltipFormat;
        return $this;
    }

    /**
     * @return Base
     */
    public function setMoneyTooltipFormat() {
        return $this->setTooltipFormat('{name}: ${value}');
    }

    /**
     * @param $callback
     * @return $this
     */
    public function onTooltip($callback) {
        $this->_tooltipCallback = $callback ? new JsExpression($callback) : null;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $xAxisID
     */
    public function setXAxisID($xAxisID) {
        $this->_xAxisID = $xAxisID;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $yAxisID
     */
    public function setYAxisID($yAxisID) {
        $this->_yAxisID = $yAxisID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getYAxisID()
    {
        return $this->_yAxisID;
    }


    /**
     * @param $hidden
     * @return $this
     */
    public function setHidden($hidden) {
        $this->_hidden = (bool)$hidden;
        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function addAdditionalParam($name, $value) {
        $this->_additional[$name] = $value;
        return $this;
    }


}