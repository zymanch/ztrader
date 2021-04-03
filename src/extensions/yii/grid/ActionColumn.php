<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 15:48
 */

namespace app\extensions\yii\grid;

use yii\grid\ActionColumn as YiiGridActionColumn;

class ActionColumn extends YiiGridActionColumn
{

    public $contentOptions = ['class' => 'text-right'];
    public $headerOptions = ['class' => 'text-right'];
    public $template = '<div class="btn-group">{view}{edit}{delete}</div>';
    public $header = 'Action';

}