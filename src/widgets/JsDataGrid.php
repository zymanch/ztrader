<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets;
use yii\grid\DataColumn;

/**
 * to make row clickable, add 'clickable-row' class to rowOptions
*/
class JsDataGrid extends InspiniaGrid {

    private static $_jsLoaded = false;

    public $responsive = true;

    public $ondraw;

    public $layout = "{items}";

    public function init(){
        parent::init();
        if(!self::$_jsLoaded){
            self::$_jsLoaded = true;
            $this->view->registerCssFile('/css/plugins/dataTables/datatables.min.css');
            $this->view->registerJsFile('/js/plugins/dataTables/datatables.min.js');
        }
        $this->_renderJs();
        if ($this->dataProvider->getPagination()) {
            $this->dataProvider->getPagination()->setPageSize(false);
        }
        foreach ($this->columns as $column) {
            $column->enableSorting = false;
        }
    }


    private function _renderJs() {
        $callbacks = [];
        if ($this->ondraw) {
            $callbacks[] = 'drawCallback: ' . $this->ondraw;
        }
        $pageSize = $this->dataProvider->getPagination() ? $this->dataProvider->getPagination()->getPageSize() : false;
        $js = sprintf('
            var $table = $("#%s table").DataTable({
                pageLength: %s,
                paging: %s,
                searching: false,
                order: [%s],
                %s
                responsive: %s
            });',
            $this->id,
            $pageSize ? $pageSize : 'false',
            $pageSize ? 'true' : 'false',
            json_encode($this->_getDefaultOrder()),
            $callbacks ? implode(',', $callbacks).',' : '',
            json_encode($this->responsive)
        );
        $this->view->registerJs($js);
    }

    private function _getDefaultOrder() {
        if (!$this->dataProvider->getSort()) {
            return [];
        }
        $sort = $this->dataProvider->getSort();
        $defaultOrder = array_keys($sort->defaultOrder);
        if (!$defaultOrder) {
            return [];
        }
        $defaultOrder = reset($defaultOrder);
        /** @var DataColumn $column */
        foreach ($this->columns as $index => $column) {
            if ($column instanceof DataColumn && $column->attribute == $defaultOrder) {
                return [$index, $sort->defaultOrder[$defaultOrder] === SORT_ASC ? 'asc':'desc'];
            }
        }
        return [];
    }


}