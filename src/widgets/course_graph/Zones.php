<?php
namespace app\widgets\course_graph;
use backend\components\repository\Course;
use backend\components\repository\Currency;
use backend\components\repository\MarketCondition;
use yii\helpers\ArrayHelper;

class Zones extends Base {

    public $currency;
    public $borderColor = 'rgba(255, 241, 189, 1.0)';
    public $backgroundColor = 'rgba(255, 241, 189, 1.0)';

    public function getDatasets()
    {
        $this->_getZones();
        return [
            [
                'label' => 'Зона',
                'data'  => $this->_getZones(),
                'borderColor' => $this->borderColor,
                'backgroundColor' => $this->backgroundColor,
                'pointRadius'	=> 0,
                'borderWidth'	=> 1,
                'yAxisID' => 'little',

            ]
        ];
    }

    private function _getZones()
    {
        $condition = new MarketCondition;
        $zones = $condition->getZones(
            $this->currency,
            $this->graph->from,
            $this->graph->to
        );
        $result = [];
        $period = new \DatePeriod($this->graph->from, new \DateInterval('PT'.$this->graph->getTickInSec().'S'),$this->graph->to);
        foreach ($period as $date) {
            $isAdded = false;
            foreach ($zones as $zone) {
                if ($zone['from']->getTimestamp()<=$date->getTimestamp() && $date->getTimestamp()<=$zone['to']->getTimestamp()) {
                    $result[] = round($zone['change'],2);
                    $isAdded = true;
                    break;
                }
            };
            if (!$isAdded) {
                $result[] = 0;
            }
        }
        return $result;
    }
}