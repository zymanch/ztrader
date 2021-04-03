<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 22.03.2018
 * Time: 12:32
 */

namespace app\widgets;

use backend\components\calculator\DifferenceCalculator;
use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;

class Changes extends Widget
{
    /**
     * @var $calculator DifferenceCalculator
     */
    public $classWrapper;
    public $grossTotal;
    public $floatMargins = true;
    public $height = 90;
    public $period;
    public $title;
    public $currentPeriodValue;
    public $previousPeriodValue;

    protected $mainWrapperClass = ['ibox'];

    public function run()
    {
        return Html::tag('div',
            $this->_getTitle() . $this->_getContent(),
            ['class' => $this->_getWrapperClasses()]);
    }

    /**
     * @return string
     */
    protected function _getTitle()
    {
        $title = $this->title ? '<h5>' . $this->title . '</h5>' : '';
        return $title ? Html::tag('div', $this->_getLabel() . $title, ['class' => 'ibox-title']) : '';
    }

    /**
     * @return string
     */
    protected function _getLabel()
    {
        if (!$this->period) {
            return '';
        }

        $classes = ['label', 'pull-right'];
        $classes[] = 'label-' . ($this->currentPeriodValue ? 'primary' : 'danger');
        return Html::tag('span', $this->period, ['class' => $classes]);
    }

    /**
     * @return string
     */
    protected function _getContent()
    {
        $value = $this->_getValueHtml();
        $difference = $this->_getDifferenceHtml();

        $style = $this->height ? ['height' => $this->height . 'px'] : null;
        return Html::tag('div', $value . $difference, ['class' => 'ibox-content', 'style' => $style]);
    }

    /**
     * @return string
     */
    protected function _getValueHtml()
    {
        return Html::tag('h2',
            $this->_getFormattedValue(),
            ['class' => ['no-margins', 'text-nowrap']]);
    }

    /**
     * @return string
     */
    protected function _getFormattedValue()
    {
        return Html::tag('span',
            $this->currentPeriodValue.
            $this->_getPercentFromTotal(),
            ['class' => $this->_getValueColorClass()]);
    }

    /**
     * @return string
     */
    protected function _getPercentFromTotal()
    {
        if (!$this->grossTotal) {
            return '';
        }

        $percentFromTotal = round(abs($this->currentPeriodValue) / $this->grossTotal * 100, 2);
        if ($percentFromTotal <= 0) {
            return '';
        }
        return Html::tag('span',
            '(' . $percentFromTotal . '%)',
            [
                'class' => 'gross-percent',
                'title' => 'Gross total: ' . $this->grossTotal
            ]);
    }

    /**
     * @return string
     */
    protected function _getValueColorClass()
    {
        return $this->currentPeriodValue >= 0 ? '' : 'text-danger';
    }

    /**
     * @return bool
     */
    protected function _isValueIncreased()
    {
        return $this->currentPeriodValue >= $this->previousPeriodValue;
    }

    /**
     * @return string
     */
    protected function _getDifferenceHtml()
    {
        if ($this->previousPeriodValue === null) {
            return '';
        }
        $caption = Html::tag('small', 'Changes');
        $difference = Html::tag('div',
            $this->_getDifference() . $this->_getIcon(),
            [
                'class' => ['stat-percent', 'font-bold', $this->_getDifferenceColorClass()],
                'title' => $this->previousPeriodValue . ' in previous period'
            ]
        );

        return Html::tag('div', $difference . $caption, ['class' => 'm-t-sm']);
    }

    /**
     * @return string
     */
    protected function _getDifferenceColorClass()
    {
        return 'text-' . ($this->_isValueIncreased() ? 'info' : 'danger');
    }

    /**
     * @return string
     */
    protected function _getDifference()
    {
        if ($this->previousPeriodValue) {
            $difference = round(100 * ($this->currentPeriodValue - $this->previousPeriodValue) / $this->previousPeriodValue);
        } else {
            $difference = $this->currentPeriodValue ? '&infin;' : 0;
        }
        return abs($difference) . '% ';
    }

    /**
     * @return string
     */
    protected function _getIcon()
    {
        $class = ['fa'];
        $class[] = $this->_isPositiveChange() ? 'fa-level-up' : 'fa-level-down';
        return Html::tag('i', null, ['class' => $class]);
    }

    /**
     * @return bool
     */
    protected function _isPositiveChange()
    {
        return ($this->currentPeriodValue >= 0 && $this->_isValueIncreased()) ||
            ($this->currentPeriodValue < 0 && !$this->_isValueIncreased());
    }

    /**
     * @return string
     */
    protected function _getWrapperClasses()
    {
        $classes = $this->mainWrapperClass;

        if (is_array($this->classWrapper)) {
            $classes = array_merge($classes, $this->classWrapper);
        } elseif (is_string($this->classWrapper)) {
            $classes = array_merge($classes, explode(' ', $this->classWrapper));
        }

        if ($this->floatMargins) {
            $classes[] = 'float-e-margins';
        }
        return implode(' ', array_unique($classes));
    }
}