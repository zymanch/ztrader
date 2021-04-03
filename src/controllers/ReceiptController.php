<?php

namespace backend\controllers;

use backend\components\repository\TestRepository;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class ReceiptController extends Controller
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
                        'actions' => ['index','create'],
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

    public function actionCreate()
    {

        return $this->render('create', [
        ]);
    }

}
