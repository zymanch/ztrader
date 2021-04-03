<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 13.07.2018
 * Time: 10:07
 */

namespace app\widgets;


use backend\models\User;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class MainMenu extends Widget
{
    public $title = '';

    public function run()
    {
        return Html::tag('div', $this->_getTitleHtml(), [
            'class' => 'navbar-header'
        ]);
    }

    protected function _getTitleHtml()
    {
        return Html::a($this->title, ['home/index'], [
            'class' => 'navbar-brand',
        ]);
    }

    protected function _getMenuHtml()
    {
        return Html::tag(
            'ul',
            implode("\n", array_map(function ($item) {
                return Html::tag('li', Html::a($item['icon'] . ' ' .$item['label'], $item['url']));
            }, [])),
            ['class' => 'dropdown-menu dropdown-alerts']
        );
    }


}