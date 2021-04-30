<?php

namespace backend\controllers;

use backend\components\repository\TestRepository;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class HomeController extends base\Controller
{


    /**
     * @inheritdoc
     *
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {

        return $this->render('index', [
        ]);
    }

}
