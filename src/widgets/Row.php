<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets;

use Yii;
use yii\bootstrap\Widget;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 *
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Row extends Widget
{

    /**
     * @var array Example: [['size' => 'xs-1 lg-3','content'=>'...'],...]
     */
    public $cols = [];


    public function run()
    {
        $cols = [];
        foreach ($this->cols as $col) {
            $cols[] = sprintf(
                '<div class="%s">%s</div>',
                'col-'.implode(' col-',explode(' ',$col['size'])),
                $col['content']
            );
        }
        return '<div class="row">'.
            implode('', $cols).
        '</div>';
    }
}
