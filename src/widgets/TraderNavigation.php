<?php

namespace app\widgets;

use yii\bootstrap\Widget;


class TraderNavigation extends Widget {

    public $menuItemList = [
        'tools' => ['Инструменты',['trader/index']],
        'imitations' => ['Эмитации',['imitation/index']],
        'zone' => ['Состояния рынка',['zone/index']],
    ];
    public $menuItemActive;
    public $breadcrumbs = [];
    public $content;



    public function run() {
        return $this->__toString();
    }




    public function __toString() {
        try {
            return $this->view->renderFile(__DIR__.'/traderNavigation/view.php',[], $this);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

}
