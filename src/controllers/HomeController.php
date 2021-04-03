<?php

namespace backend\controllers;

use backend\components\repository\TestRepository;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class HomeController extends Controller
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
            'errors' => $this->_getErrors(),
        ]);
    }

    private function _getErrors() {
        $repository = \Yii::$container->get(TestRepository::class);
        return $repository->getAllErrors();
    }
}
