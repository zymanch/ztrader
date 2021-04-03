<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets;

use yii\web\View;

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
class ICheck extends \yii\base\Widget
{

    private static $_isLoaded = [];

    public $selector = '.i-checks';

    public function run()
    {
        $this->_loadJs();
    }

    private function _loadJs() {
        if (isset(self::$_isLoaded[$this->selector])) {
            return;
        }
        self::$_isLoaded[$this->selector] = true;
        $this->view->registerJsFile('/js/icheck'.(YII_DEBUG?'':'.min').'.js');
        $this->view->registerJs(sprintf('
            $("%s").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green",
            });
        ',$this->selector), View::POS_LOAD);
    }
}
