<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph;

use app\widgets\graph\contract\Chart;
use app\widgets\graph\contract\Config;
use app\widgets\graph\contract\Dataset;
use app\widgets\graph\contract\Plugin;
use yii\base\Widget as Base;
use yii\helpers\BaseJson;
use yii\web\View;

/**
 * to make row clickable, add 'clickable-row' class to rowOptions
 * @see http://www.chartjs.org/docs/latest/
*/
class Widget extends Base {

    const TYPE_LINE = 'line';
    const TYPE_DOUGHNUT = 'doughnut';
    const TYPE_BAR = 'bar';
    const TYPE_RADAR = 'radar';
    const TYPE_PIE = 'pie';
    const TYPE_POLAR_AREA = 'polarArea';
    const TYPE_BUBBLE = 'bubble';

    public $type;

    /** @var Config[]  */
    public $configs = [];

    public $labels;

    /** @var Dataset[] */
    public $datasets = [];

    public $height = 100;

    public $responsive = true;

    public function run(){
        $this->_init();
        $this->_includeAssets();
        return $this->_renderChart();
    }

    protected function _renderChart() {
        if (!$this->datasets) {
            return '';
        }
        $labels = $this->_getLabels();
        $datasets = $this->_getDatasets();
        $options = $this->_getNormalizeOptions($datasets, $labels);
        $this->view->registerJs(
            sprintf(
                'new Chart(document.getElementById("%s").getContext("2d"), {
                    type: "%s",
                    data: {labels:%s, datasets:%s},
                    options: %s
                });',
                $this->id,
                $this->_getType(),
                BaseJson::encode($labels),
                BaseJson::encode($datasets),
                BaseJson::encode($options)
            ),
            View::POS_READY
        );
        return '<canvas id="'.$this->id.'" height="'.$this->height.'"></canvas>';
    }

    protected function _init() {
        if (!$this->id) {
            $this->id = 'graph'.mt_rand(0,time());
        }
    }

    protected function _getDatasets() {
        $result = [];
        foreach ($this->datasets as $dataset) {
            $result[] = $dataset->asDataset();
        }
        return $result;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function _getLabels() {
        if ($this->labels !== null) {
            $labels = $this->labels;
        } else {
            $labels = reset($this->datasets)->getLabels();
        }
        foreach ($this->datasets as $dataset) {
            if (count($dataset->getLabels()) !== count($labels)) {
                throw new \Exception('Provided labels is not equals');
            }
        }

        return $labels;
    }

    protected function _includeAssets() {
        $this->view->registerJsFile('/js/plugins/chartJs/Chart.min.js');
    }

    protected function _getNormalizeOptions($datasets, $labels) {
        $result = [
            'responsive' => $this->responsive
        ];
        foreach ($this->configs as $config) {
            $result = $this->_mergeConfigs(
                $result,
                $config->getConfiguration($labels, $datasets)
            );
        }
        return $result;
    }

    protected function _mergeConfigs($oldConfig, $newConfig) {
        $result = $oldConfig;
        foreach ($newConfig as $key => $value) {
            if (!isset($result[$key])) {
                $result[$key] = $value;
            } elseif(is_numeric($key)) {
                $result[] = $value;
            } elseif (is_array($value)) {
                $result[$key] = $this->_mergeConfigs($result[$key], $value);
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    protected function _getType() {
        if ($this->type) {
            return $this->type;
        }
        if (!$this->datasets) {
            return Dataset::TYPE_LINE;
        }
        foreach ($this->datasets as $dataset) {
            if ($dataset->getType() === Dataset::TYPE_BAR) {
                return Dataset::TYPE_BAR;
            }
        }
        $dataset = reset($this->datasets);
        return $dataset->getType();
    }

}