<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 15:48
 */

namespace app\extensions\yii\grid;

use app\extensions\yii\helpers\Html;
use Closure;

class HiddenRowColumn extends DataColumn{

    //will be rendered only if showHeader == true
    public function renderHeaderCell(){
        return Html::tag('th', '', ['data-breakpoints' => 'all', 'data-title' => '']);
    }

    public function renderDataCell($model, $key, $index){
        if ($this->contentOptions instanceof Closure) {
            $options = call_user_func($this->contentOptions, $model, $key, $index, $this);
        } else {
            $options = $this->contentOptions;
        }
        if(isset($this->grid->showHeader) && $this->grid->showHeader == false){
            $options = array_merge($options, ['data-breakpoints' => 'all', 'data-title' => '']);
        }
        return Html::tag('td', $this->renderDataCellContent($model, $key, $index), $options);
    }

}