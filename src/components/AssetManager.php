<?php
namespace backend\components;
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 30.03.2018
 * Time: 10:52
 */
class AssetManager extends \yii\web\AssetManager {

    public $appendTimestamp = true;

    public function init() {
        $this->hashCallback = function($path){
            $path = (is_file($path) ? dirname($path) : $path);
            return sprintf('%x', crc32($path . \Yii::getVersion()));
        };
        parent::init();
    }

}