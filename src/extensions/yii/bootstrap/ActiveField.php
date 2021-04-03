<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 12:03
 */
namespace app\extensions\yii\bootstrap;

use yii\bootstrap\ActiveField as YiiBootstrapActiveField;
use yii\helpers\ArrayHelper;

class ActiveField extends YiiBootstrapActiveField{

    public $dateTimePickerTemplate = "{label}\n<div class=\"input-group date\" data-provide=\"datepicker\" data-date-format=\"yyyy-mm-dd\"><span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>\n{input}\n{error}\n</div>\n{hint}";

    public function datePicker($options = []){
        if (!isset($options['template'])) {
            $this->template = $this->dateTimePickerTemplate;
        } else {
            $this->template = $options['template'];
            unset($options['template']);
        }

        if(isset($options['label'])){
            $this->label($options['label']);
            unset($options['label']);
        }

        parent::textInput($options);
        return $this;
    }

    public function dropDownList($items, $options = []){
        if(!$items){
            $items = ArrayHelper::remove($options, 'items');
        }

        if(isset($options['label'])){
            $this->label($options['label']);
            unset($options['label']);
        }

        return parent::dropDownList($items, $options);
    }

    public function textInput($options = []){
        if(isset($options['label'])){
            $this->label($options['label']);
            unset($options['label']);
        }

        return parent::textInput($options);
    }


}