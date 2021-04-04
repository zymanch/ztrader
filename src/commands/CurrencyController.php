<?php
namespace backend\commands;

use backend\components\repository\Course;
use yii\console\Controller;

class CurrencyController extends Controller {

    public $filename;

    public function options($actionID)
    {
        switch ($actionID) {
            case 'import':
            case 'import-multi':
                return ['filename'];
            default:
                return [];
        }

    }

    // Dump placed here:
    // https://www.finam.ru/profile/cryptocurrencies/btc-usd/export/
    public function actionImport()
    {
        $repository = new Course();
        $cources = file($this->filename);
        $columns = array_flip(explode(',',trim(array_shift($cources))));
        $dateIndex = $columns['<DATE>'];
        $timeIndex = $columns['<TIME>'];
        $valueIndex = $columns['<LAST>'];
        $volIndex = $columns['<VOL>'];
        while ($rows = array_splice($cources,0,10000)) {
            foreach ($rows as $index => $row) {
                $row = explode(',', trim($row));
                $rows[$index] = [
                    'date' => substr($row[$dateIndex],0,4).'-'.substr($row[$dateIndex],4,2).'-'.substr($row[$dateIndex],6,2).' '.
                        substr($row[$timeIndex],0,2).':'.substr($row[$timeIndex],2,2).':'.substr($row[$timeIndex],4,2),
                    'course' => round($row[$valueIndex],2),
                    'volume' => $row[$volIndex]
                ];
            }
            $repository->saveMulti('btc',$rows);
        }
    }

    public function actionSync()
    {

    }
}