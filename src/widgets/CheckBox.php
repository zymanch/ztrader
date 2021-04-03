<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets;

use yii\helpers\Html;
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
class CheckBox extends \yii\base\Widget
{

    private static $_isLoaded = false;

    public $label = '';
    public $checked = false;
    public $name = '';
    public $value = '1';

    public function run()
    {
        $this->_loadJs();
        $options = [
            'type'=>'checkbox',
            'name' => $this->name,
            'value' => $this->value
        ];
        if ($this->id) {
            $options['id'] = $this->id;
        }
        if ($this->checked) {
            $options['checked'] = 'checked';
        }
        $contents = [
            Html::tag('input','',$options),
            Html::tag('div'),
            $this->label
        ];
        return Html::tag('label',implode('',$contents),['class'=>'checkbox-simple']);
    }

    private function _loadJs() {
        if (self::$_isLoaded) {
            return;
        }
        self::$_isLoaded = true;
        $this->view->registerCssFile('/css/iCheck/simple.css');
    }
}
