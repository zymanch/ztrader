<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 15:48
 */

namespace app\extensions\yii\grid;

class AdminActionColumn extends ActionColumn
{
    public $template = '<div class="btn-group">{update}&nbsp;&nbsp;{delete}</div>';
}