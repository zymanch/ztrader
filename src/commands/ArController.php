<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\commands;

use yii\console\Controller;

class ArController extends Controller
{

    public $tables;

    public function options($actionID)
    {
        return ['tables'];
    }

    public function actionIndex()
    {
        if (!$this->tables) {
            // not for all tables need AR
            $this->tables = 'ztrader:' . implode(',', [
                'user','user_receipt','receipt'
            ]);
        }
        $helper = new \ActiveGenerator\generator\ScriptHelper();
        $helper->baseClass = 'yii\db\ActiveRecord';
        $helper->queryBaseClass = 'yii\db\ActiveQuery';
        $helper->namespace = 'backend\models';
        $helper->prefix = 'Base';
        $helper->sub = 'base';
        $helper->path = \Yii::getAlias('@backend/models');
        $helper->generate(
            \Yii::$app->db->masterPdo,
            $this->tables
        );
    }

}
