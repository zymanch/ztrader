<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 16:30
 */

namespace app\extensions\yii\helpers;

use yii\helpers\BaseHtml;

/**
 * Html provides a set of static methods for generating commonly used HTML tags.
 *
 * Nearly all of the methods in this class allow setting additional html attributes for the html
 * tags they generate. You can specify for example. 'class', 'style'  or 'id' for an html element
 * using the `$options` parameter. See the documentation of the [[tag()]] method for more details.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Html extends BaseHtml{

    public static function progress($value, $options = []){
        if(isset($options['class'])){
            $options['class'] = 'progress ' . $options['class'];
        } else {
            $options['class'] = 'progress';
        }

        if(isset($options['bar'])){
            $progressBarClass = 'progress-bar ' . $options['bar'];
        } else {
            $progressBarClass = 'progress-bar';
        }

        $progressBar = Html::tag('div', '', ['class' => $progressBarClass, 'style' => 'width: ' . intval($value) . '%;']);

        return Html::tag('div', $progressBar, $options);
    }

    public static function ellipsis($text, $maximumSymbols = 50, $ellipsisText = '...'){
        return mb_substr($text, 0, $maximumSymbols) . (strlen($text) > $maximumSymbols ? $ellipsisText : '');
    }

}