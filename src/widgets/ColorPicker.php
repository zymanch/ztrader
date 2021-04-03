<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets;

use Yii;
use yii\helpers\Html;

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
class ColorPicker extends \yii\base\Widget
{

    private static $_isLoaded = false;

    public $tag = 'input';
    public $htmlOptions = ['type'=>'text'];


    public function run()
    {
        $this->_loadJs();
        if (!isset($this->htmlOptions['class'])) {
            $this->htmlOptions['class'] = '';
        }
        $this->htmlOptions['class'] = trim($this->htmlOptions['class'].' colorpick');
        return Html::tag($this->tag, '', $this->htmlOptions);
    }

    private function _loadJs() {
        if (self::$_isLoaded) {
            return;
        }
        self::$_isLoaded = true;
        $this->view->registerCssFile('@web/css/plugins/colorpicker/bootstrap-colorpicker.css');
        $this->view->registerJsFile('@web/js/plugins/colorpicker/bootstrap-colorpicker.js');
        $this->view->registerJs('
            $(".colorpick").colorpicker({format:"hex"});
            $(".colorpick").each(function () {
                $(this).css("background-color", $(this).val());
              });
              
            $(".colorpick").colorpicker().on("colorpickerChange", function (e) {
                $(this).css("background-color", $(this).val());
            });
        ');
    }
}
