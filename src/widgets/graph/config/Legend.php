<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\config;

use app\widgets\graph\contract\Config;
use backend\traits\ClearArray;
use backend\traits\Create;
use yii\web\JsExpression;

class Legend implements Config {

    const POSITION_LEFT = 'left';
    const POSITION_RIGHT = 'right';
    const POSITION_BOTTOM = 'bottom';
    const POSITION_TOP = 'top';

    use Create;
    use ClearArray;


    protected $_display;
    protected $_position;
    protected $_fullWidth;
    protected $_onClick;
    protected $_reverse;
    protected $_labels;

    public function getConfiguration($labels, $datasets) {

        $axeConfig = [
            'display' => $this->_display,
            'position' => $this->_position,
            'fullWidth' => $this->_fullWidth,
            'onClick' => $this->_onClick,
            'reverse' => $this->_reverse,
            'labels' => $this->_labels,
        ];
        return  ['legend' => $this->_clearArray($axeConfig)];

    }

    /**
     * @return $this
     */
    public function show() {
        $this->_display = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function hide() {
        $this->_display = false;
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
     */
    public function enableFullWidth() {
        $this->_fullWidth = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableFullWidth() {
        $this->_fullWidth = false;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onClick
     */
    public function onClick($onClick) {
        $this->_onClick = new JsExpression($onClick);
        return $this;
    }

    /**
     * @return $this
     */
    public function enableReverse() {
        $this->_reverse = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableReverse() {
        $this->_reverse = false;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $labels
     */
    public function setLabels($labels) {
        $this->_labels = $labels;
        return $this;
    }

    /**
     * @param $url
     * @return Legend
     */
    public function callUrlOnChangeVisibility($url) {
        return $this->onClick(sprintf('function(e, legendItem) {
            var index = legendItem.datasetIndex;
            var ci = this.chart;
            var meta = ci.getDatasetMeta(index);
            meta.hidden = meta.hidden === null? !ci.data.datasets[index].hidden : null;
            ci.update();
            $.get("%s",{
                "target_type": ci.data.datasets[index].target_type, 
                "target_id": ci.data.datasets[index].target_id, 
                "is_checked": meta.hidden ? "" : "1"
            });
        }',$url));
    }
}