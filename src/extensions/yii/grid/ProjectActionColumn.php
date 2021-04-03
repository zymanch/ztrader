<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 15:48
 */

namespace app\extensions\yii\grid;

use Yii;
use yii\helpers\Html;

class ProjectActionColumn extends ActionColumn
{
    public $template = '<div class="btn-group">{billing}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}</div>';
    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        $this->initDefaultButton('billing', 'usd');
    }

    /**
     * Initializes the default button rendering callback for single button.
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false
                && $name === 'billing') {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                $title = Yii::t('yii', 'Billing');
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        } else {
            parent::initDefaultButton($name, $iconName, $additionalOptions);
        }
    }
}