<?php

namespace backend\components\behavior;

use yii\base\Behavior;

/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 23.02.2018
 * Time: 12:07
 */
class Trace extends Behavior {

    const BEFORE = 'before';
    const AFTER = 'after';

    public $events = [];

    public $title;

    public $category;

    /**
     * @inheritdoc
     */
    public function attach($owner) {
        $this->owner = $owner;
        foreach ($this->events as $event => $time) {
            switch ($time) {
                case self::BEFORE:
                    $owner->on($event, [$this, 'beforeExec']);
                    break;
                case self::AFTER:
                    $owner->on($event, [$this, 'afterExec']);
                    break;
                default:
                    throw new \Exception('Wrong eventss configuration');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function detach() {
        if ($this->owner === null) {
            return;
        }
        foreach ($this->events as $event => $time) {
            switch ($time) {
                case self::BEFORE:
                    $this->owner->off($event, [$this, 'beforeExec']);
                    break;
                case self::AFTER:
                    $this->owner->off($event, [$this, 'afterExec']);
                    break;
                default:
                    throw new \Exception('Wrong eventss configuration');
            }
        }
        $this->owner = null;
    }

    public function beforeExec() {
        \Yii::beginProfile($this->title, $this->_getCategory());
    }

    public function afterExec() {
        \Yii::endProfile($this->title, $this->_getCategory());
    }

    protected function _getCategory() {
        $reflection = new \ReflectionClass($this->owner);
        return $reflection->getShortName();
    }

}