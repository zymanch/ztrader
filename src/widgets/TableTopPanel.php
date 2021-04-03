<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 22.06.18
 * Time: 16:25
 */

namespace app\widgets;


use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class TableTopPanel extends Widget
{
    public $map = [];

    public function run()
    {
        $menu = [];
        foreach ($this->map as $type => $topMenu) {
            if (!empty($topMenu['items'])) {
                $button = $this->_buildButton($topMenu);
                $list = $this->_buildList($topMenu);
                $menu[] = $this->_buildButtonGroup($button, $list);
            }
        }
        return Html::tag(
            'div',
            implode("\n", $menu),
            ['class' => 'pull-right']
        );
    }

    /**
     * @param $topMenu
     * @return string
     */
    public function _buildButton($topMenu)
    {
        $caret = Html::tag('span', '', ['class' => 'caret']);
        $button = Html::tag('button', $topMenu['title'] . ' ' . $caret, [
            'class' => $topMenu['class'],
            'data' => ['toggle' => 'dropdown']
        ]);
        return $button;
    }

    /**
     * @param $topMenu
     * @return string
     */
    public function _buildList($topMenu)
    {
        $list = Html::ul($topMenu['items'], [
            'item' => function ($link, $title) {
                return Html::tag('li',
                    Html::a($title, $link)
                );
            },
            'class' => 'dropdown-menu'
        ]);
        return $list;
    }

    /**
     * @param $button
     * @param $list
     * @return string
     */
    public function _buildButtonGroup($button, $list)
    {
        return Html::tag(
            'div',
            $button . $list,
            ['class' => 'btn-group ml-3 mr-3']
        );
    }
}