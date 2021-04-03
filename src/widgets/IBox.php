<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets;

use backend\components\behavior\Trace;
use yii\bootstrap\Widget;

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
class IBox extends Widget
{

    public $title_text;

    public $scroll_id;
    public $title_label;
    public $title_type = 'success';
    public $title_right;
    public $content;
    public $content_title;
    public $summary_left;
    public $summary_right;
    public $summary_type = 'success';
    public $summary_icon;
    public $height;
    public $h = 'h1';
    public $contentWrapperClass;
    public $classWrapper;
    public $button = false;
    public $floatMargins = true;

    public function behaviors() {
        return [
            'trace' => [
                'class' => Trace::class,
                'events' => [
                    self::EVENT_BEFORE_RUN => Trace::BEFORE,
                    self::EVENT_AFTER_RUN => Trace::AFTER,
                ],
                'title' => $this->title_label ?: strip_tags($this->title_text),
            ]
        ];
    }

    public function run()
    {
        $title = $this->_getTitle();
        $content = $this->_getContent();
        $classes = ['ibox'];
        if ($this->floatMargins) {
            $classes[]= 'float-e-margins';
        }
        $classes[] = $this->classWrapper;
        return sprintf(
            '%s<div class="%s" %s>%s%s</div>',
            $this->scroll_id ? '<div id="'.$this->scroll_id.'" class="scroll-element"></div>':'',
            implode(' ',$classes),
            ($this->id?'id="'.$this->id.'"':''),
            $title,
            $content
        );
    }

    protected function _getTitle() {
        $title = $this->title_text?'<span style="font-weight: bold;font-size: 30px">'.$this->title_text.'</span>':'';
        if ($this->title_label) {
            $title='<span class="label label-'.$this->title_type.' pull-right">'.$this->title_label.'</span>'.$title;
        }

        if ($this->title_right) {
            $title.=sprintf('<div class="pull-right">%s</div>',$this->title_right);
        }
        if ($this->button) {
            $buttons = is_array($this->button) ? $this->button : [$this->button];
            $title .= implode(' ', $buttons);
        }

        if (!$title) {
            return '';
        }
        return '<div class="ibox-title">'.$title.'</div>';
    }

    protected function _getContent() {
        $content = $this->content;
        if ($this->content_title!==null) {
            $content.='<' . $this->h . ' class="no-margins text-nowrap">'.$this->content_title.'</' . $this->h . '>';
        }
        $content .= '<div class="' . $this->contentWrapperClass . '">';
        if ($this->summary_right!==null) {
            $content.='<div class="stat-percent font-bold text-'.$this->summary_type.'">'.
                $this->summary_right.
                ($this->summary_icon?'<i class="fa fa-'.$this->summary_icon.'"></i>':'').
                '</div>';
        }
        if ($this->summary_left!==null) {
            $content.='<small>'.$this->summary_left.'</small>';
        }
        $content .= '</div>';
        if (!$content) {
            return '';
        }
        $height = $this->height ? ' style="height:'.$this->height.'px"':'';
        return '<div class="ibox-content"'.$height.'>'.$content.'</div>';
    }
}
