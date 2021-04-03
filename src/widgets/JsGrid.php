<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets;

use yii\grid\Column;
use yii\grid\DataColumn;
use yii\grid\GridView;
use yii\helpers\Html;


class JsGrid extends GridView
{

    public $tableOptions = ['class' => 'table table-stripped table-hover table-pointer toggle-arrow-tiny default'];

    public function init() {
        parent::init();
        $this->view->registerCssFile('/css/jqGrid/ui.jqgrid.css');
        $this->view->registerJsFile('/js/plugins/jqGrid/i18n/grid.locale-en.js');
        $this->view->registerJsFile('/js/plugins/jqGrid/jquery.jqGrid.min.js');
    }

    public function run() {
        $this->view->registerJs(sprintf(
            '$("#%s").jqGrid(%s);',
            $this->options['id'],
            json_encode([
                'data' => $this->_getTableData(),
                'datatype' => "local",
                'height' => 150,
                'autowidth' => true,
                'shrinkToFit' => true,
                //'rowNum' => 14,
                //'rowList' => [10, 20, 30],
                'colNames' => $this->_getTableColumnsName(),
                'colModel' => $this->_getTableColumns(),
                //'pager' => "#pager_list_1",
                'viewrecords' => true,
                //'caption' => "Example jqGrid 1",
                'hidegrid' => false
            ])
        ));
        return $this->_getHtml();
    }

    protected function _getHtml() {
        return Html::tag('table', '', array_merge($this->tableOptions,$this->options));
    }

    protected function _getTableColumns() {
        $result = [];
        /** @var DataColumn $column */
        foreach ($this->columns as $index => $column) {
            $result[] = [
                'name' => 'c'.$index,
                'index' => $index,
                //'width' => 60,
                //'sorttype' => "int"
            ];
        }
        return $result;
    }

    protected function _getTableColumnsName() {
        $result = [];
        /** @var DataColumn $column */
        foreach ($this->columns as $index => $column) {
            $result[] = $column->label;
        }
        return $result;
    }

    protected function _getTableData() {
        $models = array_values($this->dataProvider->getModels());
        $keys = $this->dataProvider->getKeys();
        $rows = [];
        foreach ($models as $index => $model) {
            $key = $keys[$index];
            $row = [];
            /** @var DataColumn $column */
            foreach ($this->columns as $col => $column) {
                $row['c'.$col] = $column->getDataCellValue($model, $key, $index);
            }
            $rows[] = $row;
        }

        return $rows;
    }
}
