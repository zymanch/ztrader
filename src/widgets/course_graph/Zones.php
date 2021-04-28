<?php
namespace app\widgets\course_graph;
use backend\components\repository\Course;
use backend\components\repository\Currency;
use backend\components\repository\MarketCondition;
use backend\components\repository\Zone;
use yii\helpers\ArrayHelper;

class Zones extends Base {

    public $currency;
    public $borderColor = '#fbdeff';
    public $backgroundColor = '#fbdeff';

    private $_data;
    private $_tooltips;

    public function getDatasets()
    {
        $this->_fillZones();
        return [
            [
                'label' => 'Зона',
                'data'  => $this->_data,
                'tooltips'  => $this->_tooltips,
                'borderColor' => $this->borderColor,
                'backgroundColor' => $this->backgroundColor,
                'pointRadius'	=> 2,
                'borderWidth'	=> 1,
                'yAxisID' => 'little',

            ]
        ];
    }

    private function _fillZones()
    {
        $this->_data = [];
        $this->_tooltips = [];
        $condition = new MarketCondition;
        $zones = $condition->getZones(
            $this->currency,
            $this->graph->from,
            $this->graph->to
        );
        //print '<pre>';var_dump($zones);die();
        $result = [];
        $lastTooltip = '';
        $period = new \DatePeriod($this->graph->from, new \DateInterval('PT'.$this->graph->getTickInSec().'S'),$this->graph->to);
        foreach ($period as $date) {
            $isAdded = false;
            foreach ($zones as $zone) {
                if ($zone['from']->getTimestamp()<=$date->getTimestamp() && $date->getTimestamp()<=$zone['to']->getTimestamp()) {
                    $this->_data[] = round($zone['change'],2);
                    $lastTooltip = 'Изменение на '.round($zone['change'],2)."%\n".
                                         'Размер '.gmdate('H:i',$zone['size']*Zone::ZONE_SIZE_SEC).' ('.$zone['size'].')';
                    $this->_tooltips[] = $lastTooltip;
                    $isAdded = true;
                    break;
                }
            };
            if (!$isAdded) {
                $this->_data[] = 0;
                $this->_tooltips[] = $lastTooltip;
            }
        }
        return $result;
    }
}