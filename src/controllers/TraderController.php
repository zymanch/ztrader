<?php

namespace backend\controllers;


use ActiveGenerator\Criteria;
use backend\models\forms\UploadReceiptForm;
use backend\models\Receipt;
use backend\models\ReceiptQuery;
use backend\models\TraderImitation;
use backend\models\TraderImitationQuery;
use backend\models\TraderQuery;
use backend\models\UserReceipt;
use backend\models\UserReceiptQuery;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class TraderController extends Controller
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
                        'actions' => ['index','create','view','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $traders = TraderQuery::model()->orderByName()->all();
        return $this->render('index', [
            'traders' => $traders
        ]);
    }

    public function actionView(int $id)
    {
        $trader = TraderQuery::model()->filterByTraderId($id)->one();
        if (!$trader) {
            throw new NotFoundHttpException('Трейдер не найден');
        }
        return $this->render('view', [
            'model' => $trader
        ]);
    }

}
