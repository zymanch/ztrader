<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\config\axe;

use app\widgets\graph\contract\Ticks;
use backend\traits\Create;
use yii\web\JsExpression;

abstract class Cartesian extends Axe {

    const POSITION_LEFT = 'left';
    const POSITION_RIGHT = 'right';

    use Create;

    protected $_id;
    protected $_position;
    protected $_offset;
    protected $_gridLines;
    protected $_scaleLabel;
    /** @var  Ticks */
    protected $_ticks;
    protected $_afterBuildTicks;

    /**
     * @return $this
     * @param mixed $id
     */
    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $position
     */
    public function setPosition($position) {
        $this->_position = $position;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $offset
     */
    public function setOffset($offset) {
        $this->_offset = $offset;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $gridLines
     */
    public function setGridLines($gridLines) {
        $this->_gridLines = $gridLines;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $scaleLabel
     */
    public function setScaleLabel($scaleLabel) {
        $this->_scaleLabel = $scaleLabel;
        return $this;
    }


    protected function _getConfiguration($labels, $datasets) {

        $axeConfig = [
            'type' => $this->_getType(),
            'position' => $this->_position,
            'offset' => $this->_offset,
            'id' => $this->_id,
            'gridLines' => $this->_gridLines,
            'scaleLabel' => $this->_scaleLabel,
            'ticks' => $this->getTicks()->getConfiguration($this->_id, $labels, $datasets),
            'afterBuildTicks' => $this->_afterBuildTicks
        ];
        return array_merge(
            parent::_getConfiguration($labels, $datasets),
            $this->_clearArray($axeConfig)
        );

    }

    /**
     * @param $callback
     * @return $this
     */
    public function setAfterBuildTicks($callback) {
        $this->_afterBuildTicks = new JsExpression($callback);
        return $this;
    }

    public function getAfterBuildTicks() {
        return $this->_afterBuildTicks;
    }

    /**
     * @return Ticks
     */
    abstract public function getTicks();
}