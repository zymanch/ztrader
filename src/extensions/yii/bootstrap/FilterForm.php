<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 24.10.16
 * Time: 11:13
 */

namespace app\extensions\yii\bootstrap;

use backend\assets\AppAsset;
use yii\bootstrap\ActiveForm as YiiBootstrapActiveForm;
use yii\base\InvalidConfigException;
use Yii;

class FilterForm extends YiiBootstrapActiveForm {

    public $fieldClass = 'app\extensions\yii\bootstrap\ActiveField';

    public $buttonWrapperClass = 'col-sm-4 pull-right text-right';

    /**
     * 12 should be divided into this number without reminder, so it can be 1,2,3,4,6,12
     * 12 is maximum bootstrap columns in grid
    */
    public $columnsPerRow = 3;

    public $disableDividingToRows = false;


    /**
     * $model expected to be any model that can be used with ActiveForm
     * $config is array of pairs (attribute => array(field_attr_1 => value, ...))
    */
    public function renderFields($model, $config){

        if(!$config){
            throw new InvalidConfigException('Config is empty');
        }

        $config = $this->_normalizeConfig($config);

        if($this->_configHasDateTimeField($config)){
            $this->view->registerJsFile('/js/plugins/datepicker/bootstrap-datepicker.js', ['depends' => AppAsset::className()]);
        }

        if($this->disableDividingToRows){
            $view = Yii::getAlias('@app/extensions/views/filterFormInline.php');
        } else {
            $view = Yii::getAlias('@app/extensions/views/filterForm.php');
        }
        echo $this->view->renderFile(
            $view,
            [
                'form' => $this,
                'filterModel' => $model,
                'fields' => $config
            ]);
    }

    protected function _normalizeConfig($config){
        $result = [];
        foreach ($config as $attribute => $fieldConfig){
            if(is_int($attribute)){
                $attribute = $fieldConfig;
                $fieldConfig = [];
            }
            $result[$attribute] = $fieldConfig;
        }
        return $result;
    }

    protected function _configHasDateTimeField($config){
        foreach ($config as $item){
            if(isset($item['type']) && $item['type']  == 'datePicker'){
                return true;
            }
        }
        return false;
    }

}