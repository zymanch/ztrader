<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 18.10.16
 * Time: 17:38
 */
namespace app\widgets;

use app\extensions\yii\helpers\Html;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Nav;
use yii\helpers\ArrayHelper;

class InspiniaNav extends Nav{

    public $header = '';
    public $footer = '';
    public $activateParents = true;

    /**
     * Renders widget items.
     */
    public function renderItems()
    {
        $items = [];
        foreach ($this->items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            $items[] = $this->renderItem($item);
        }

        return '<nav class="navbar navbar-static-top" role="navigation">'.
            $this->header.
            '<div class="navbar-collapse collapse" id="navbar" aria-expanded="false">'.
                Html::tag('ul', implode("\n", $items), $this->options).
            $this->footer.
            '</div>'.
        '</nav>';
    }

    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderItem($item, $level = 1)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        $labelIcon = ArrayHelper::getValue($item, 'icon', null);

        $label = Html::tag('span', $label, ['class' => 'nav-label']);

        $badge = '';

        if (!empty($item['badge'])) {
            $badge = sprintf('<span class="label label-danger">%s</span>', $item['badge']);
        }

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if (empty($items)) {
            $items = '';
        } else {
            if ($this->dropDownCaret !== '') {
                $label .= ' ' . $this->dropDownCaret;
            } else{
                $label .= ' ' . Html::tag('span', '', ['class' => 'fa arrow']);
            }
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $items = $this->renderSubmenu($items, $level + 1);
            }
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        $labelIcon = $labelIcon ? HTML::tag('i', '', ['class' => "fa fa-$labelIcon"]) : '';

        return Html::tag('li', Html::a($labelIcon . $label . $badge, $url, $linkOptions) . $items, $options);
    }

    protected function renderSubmenu($items, $level){
        if($level > 3){
            throw new InvalidConfigException('Main menu not supports more than 3 level of nesting');
        }

        $itemsHtml = '';
        foreach ($items as $item){
            $itemsHtml .= $this->renderItem($item, $level);
        }

        switch ($level){
            case 2:
                $level = 'second';
                break;
            case 3:
                $level = 'third';
                break;
            default:
                throw new InvalidConfigException('Invalid menu level:' . $level);
                break;
        };

        return Html::tag('ul', $itemsHtml, ['class' => 'nav nav-'.$level.'-level collapse']);

    }

}