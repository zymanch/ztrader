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
class Line extends Base{

    use Create;

    protected $_borderDash;
    protected $_fill;
    protected $_pointRadius;
    protected $_pointStyle;
    protected $_isShowLine;
    protected $_steppedLine;
    protected $_lineTension;
    protected $_borderDashOffset;
    protected $_borderCapStyle;
    protected $_borderJoinStyle;
    protected $_cubicInterpolationMode;
    protected $_isSpanGaps;
    protected $_pointBackgroundColor;
    protected $_pointBorderColor;
    protected $_pointBorderWidth;
    protected $_pointHitRadius;
    protected $_pointHoverBackgroundColor;
    protected $_pointHoverBorderColor;
    protected $_pointHoverBorderWidth;
    protected $_pointHoverRadius;
    protected $_adaptiveDots;


    public function asDataset() {
        $options = [
            'borderDash' => $this->_borderDash,
            'borderDashOffset' => $this->_borderDashOffset,
            'borderCapStyle' => $this->_borderCapStyle,
            'borderJoinStyle' => $this->_borderJoinStyle,
            'cubicInterpolationMode' => $this->_cubicInterpolationMode,
            'fill' => $this->_fill,
            'lineTension' => $this->_lineTension,
            'pointBackgroundColor' => $this->_pointBackgroundColor,
            'pointBorderColor' => $this->_pointBorderColor,
            'pointBorderWidth' => $this->_pointBorderWidth,
            'pointRadius' => $this->_getPointRadius(),
            'pointStyle' => $this->_pointStyle,
            'pointHitRadius' => $this->_pointHitRadius,
            'pointHoverBackgroundColor' => $this->_pointHoverBackgroundColor,
            'pointHoverBorderColor' => $this->_pointHoverBorderColor,
            'pointHoverBorderWidth' => $this->_pointHoverBorderWidth,
            'pointHoverRadius' => $this->_pointHoverRadius,
            'showLine' => $this->_isShowLine,
            'spanGaps' => $this->_isSpanGaps,
            'steppedLine' => $this->_steppedLine,
        ];
        return array_merge(
            parent::asDataset(),
            $this->_clearArray($options)
        );
    }

    public function getType() {
        return self::TYPE_LINE;
    }

    public function setBorderDash($borderDash) {
        $this->_borderDash = $borderDash;
        return $this;
    }

    public function setFill($fill) {
        $this->_fill = $fill;
        return $this;
    }

    public function setPointRadius($pointRadius) {
        $this->_pointRadius = $pointRadius;
        return $this;
    }

    public function setPointStyle($pointStyle) {
        $this->_pointStyle = $pointStyle;
        return $this;
    }

    public function showLine() {
        $this->_isShowLine = true;
        return $this;
    }

    public function hideLine() {
        $this->_isShowLine = false;
        return $this;
    }

    public function setSteppedLine($steppedLine) {
        $this->_steppedLine = $steppedLine;
        return $this;
    }

    public function setLineTension($lineTension) {
        $this->_lineTension = $lineTension;
        return $this;
    }


    /**
     * @return $this
     * @param mixed $borderDashOffset
     */
    public function setBorderDashOffset($borderDashOffset) {
        $this->_borderDashOffset = $borderDashOffset;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $borderCapStyle
     */
    public function setBorderCapStyle($borderCapStyle) {
        $this->_borderCapStyle = $borderCapStyle;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $borderJoinStyle
     */
    public function setBorderJoinStyle($borderJoinStyle) {
        $this->_borderJoinStyle = $borderJoinStyle;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $cubicInterpolationMode
     */
    public function setCubicInterpolationMode($cubicInterpolationMode) {
        $this->_cubicInterpolationMode = $cubicInterpolationMode;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $isSpanGaps
     */
    public function setIsSpanGaps($isSpanGaps) {
        $this->_isSpanGaps = $isSpanGaps;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $pointBackgroundColor
     */
    public function setPointBackgroundColor($pointBackgroundColor) {
        $this->_pointBackgroundColor = $pointBackgroundColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $pointBorderColor
     */
    public function setPointBorderColor($pointBorderColor) {
        $this->_pointBorderColor = $pointBorderColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $pointBorderWidth
     */
    public function setPointBorderWidth($pointBorderWidth) {
        $this->_pointBorderWidth = $pointBorderWidth;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $pointHitRadius
     */
    public function setPointHitRadius($pointHitRadius) {
        $this->_pointHitRadius = $pointHitRadius;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $pointHoverBackgroundColor
     */
    public function setPointHoverBackgroundColor($pointHoverBackgroundColor) {
        $this->_pointHoverBackgroundColor = $pointHoverBackgroundColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $pointHoverBorderColor
     */
    public function setPointHoverBorderColor($pointHoverBorderColor) {
        $this->_pointHoverBorderColor = $pointHoverBorderColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $pointHoverBorderWidth
     */
    public function setPointHoverBorderWidth($pointHoverBorderWidth) {
        $this->_pointHoverBorderWidth = $pointHoverBorderWidth;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $pointHoverRadius
     */
    public function setPointHoverRadius($pointHoverRadius) {
        $this->_pointHoverRadius = $pointHoverRadius;
        return $this;
    }

    /**
     * @return $this
     */
    public function asOnlyLine() {
        $this->_borderWidth = 2;
        $this->_lineTension = 0;
        $this->_fill = false;
        return $this;
    }

    /**
     * @return $this
     */
    public function asFilled() {
        $this->_borderWidth = 2;
        $this->_lineTension = 0;
        return $this;
    }

    public function enableAdaptiveDots() {
        $this->_adaptiveDots = true;
        return $this;
    }

    protected function _getPointRadius() {
        if ($this->_pointRadius!==null) {
            return $this->_pointRadius;
        }
        if ($this->_adaptiveDots!==true) {
            return null;
        }
        $dataSize = count($this->_data->getLabels());
        if ($dataSize < 30) {
            return 3;
        }
        if ($dataSize < 50) {
            return 2;
        }
        if ($dataSize < 90) {
            return 1;
        }
        return 0;
    }
}