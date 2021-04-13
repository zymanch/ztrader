<?php
namespace backend\commands;

use backend\components\repository\Course;
use yii\console\Controller;

class CurrencyController extends Controller {

    public $filename;
    public $currency;

    public function options($actionID)
    {
        switch ($actionID) {
            case 'import':
                return ['filename','currency'];
            default:
                return [];
        }

    }

    // Dump placed here:
    // https://www.finam.ru/profile/cryptocurrencies/btc-usd/export/
    // https://www.finam.ru/profile/cryptocurrencies/eth-usd/export/
    public function actionImport() {
        if (!file_exists($this->filename)) {
            throw new \Exception('Файл дампа не найден');
        }
        if (!is_dir($this->filename)) {
            $this->_importFile($this->filename);
            return;
        }
        $files = scandir($this->filename);
        foreach ($files as $file) {
            if ($file[0]!='.') {
                $this->_importFile(rtrim($this->filename,'/').'/'.$file);
            }
        }
    }

    private function _importFile($fileName)
    {
        $repository = new Course();
        $cources = file($fileName);
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
            $repository->saveMulti(strtolower($this->currency),$rows);
        }
    }

}