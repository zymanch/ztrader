<?php

namespace app\widgets;

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Widget;
use yii\web\View;


class Dialog extends Widget {

    /** @var Dialog[] */
    protected static $_dialogs = [];
    public $header;
    public $body;
    public $footer;
    /** @var  array */
    public $form;
    public $close = true;
    public $title;

    public $buttons = [];
    protected $_isAddedToView = false;
    /** @var  ActiveForm */
    private $_form;

    public function run() {
        if (!$this->_isAddedToView) {
            $this->view->on(View::EVENT_END_BODY, [$this, 'renderDialogsHtml']);
            $this->_isAddedToView = true;
        }
        self::$_dialogs[] = $this;
        return '';
    }

    public function renderDialogsHtml() {
        $result = [];
        foreach (self::$_dialogs as $dialog) {
            $result[] = (string)$dialog;
        }
        echo implode("\n\n", $result);
    }

    public function __toString() {
        try {
            return sprintf(
                '<div class="modal fade" id="%s" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">%s</div>
    </div>
</div>',
                $this->id,
                $this->_getDialogContent()
            );
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    protected function _getDialogContent() {
        ob_start();
        if ($this->form) {
            $this->_form = ActiveForm::begin($this->form);
        }
        $title = $this->_getHeader();
        if ($title) {
            printf('<div class="modal-header">%s</div>', $title);
        }
        $body = $this->_getBody();
        if ($body) {
            printf('<div class="modal-body">%s</div>', $body);
        }
        $footer = $this->_getFooter();
        if ($footer) {
            printf('<div class="modal-footer">%s</div>', $footer);
        }
        if ($this->form) {
            ActiveForm::end();
        }
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    protected function _getHeader() {
        if (is_array($this->header)) {
            return $this->_renderView($this->header);
        }
        if ($this->header) {
            return $this->header;
        }
        if (!$this->title) {
            return '';
        }
        $close = $this->close ?
            '<button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>' :
            '';
        return $close . sprintf(
                '<h4 class="modal-title">%s</h4>',
                $this->title
            );
    }

    protected function _renderView($properties) {
        $viewFile = $properties[0];
        unset($properties[0]);
        return $this->render($viewFile, array_merge(
            ['form' => $this->_form],
            $properties
        ));
    }

    protected function _getBody() {
        if (is_array($this->body)) {
            return $this->_renderView($this->body);
        }
        return $this->body;
    }

    protected function _getFooter() {
        if (is_array($this->footer)) {
            return $this->_renderView($this->footer);
        }
        if ($this->footer) {
            return $this->footer;
        }
        return implode('', $this->buttons);
    }

}
