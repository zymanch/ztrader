<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 15:48
 */

namespace app\extensions\yii\grid;

use Closure;
use Yii;
use yii\grid\Column;
use yii\helpers\Html;

class ColorColumn extends Column
{
    public $header = 'Color';
    /**
     * Renders the data cell content.
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @return string the rendering result
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->content !== null) {
            return call_user_func($this->content, $model, $key, $index, $this) . '<div class="colorbox"></div>';
        }

        return $this->grid->emptyCell;
    }
}