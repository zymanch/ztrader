<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 15:48
 */

namespace app\extensions\yii\grid;

use app\extensions\yii\helpers\Html;
use yii\grid\DataColumn as YiiGridDataColumn;

class DataColumn extends YiiGridDataColumn{

    /**
     * Renders the header cell.
     */
    public function renderHeaderCell()
    {

        if ($this->attribute !== null && $this->enableSorting &&
            ($sort = $this->grid->dataProvider->getSort()) !== false && $sort->hasAttribute($this->attribute)) {
                if (($direction = $this->grid->dataProvider->getSort()->getAttributeOrder($this->attribute)) !== null) {
                    $class = ($direction === SORT_DESC ? 'footable-sorted-desc' : ($direction == SORT_ASC ? 'footable-sorted' : ''));
                    if (isset($this->headerOptions['class'])) {
                        $this->headerOptions['class'] .= ' ' . $class;
                    } else {
                        $this->headerOptions['class'] = $class;
                    }
                }
        }

        return Html::tag('th', $this->renderHeaderCellContent(), $this->headerOptions);
    }

}