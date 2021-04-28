<?php

namespace backend\controllers;


use ActiveGenerator\Criteria;
use backend\components\buyer\Fabric;
use backend\models\BuyerQuery;
use backend\models\forms\UploadReceiptForm;
use backend\models\Receipt;
use backend\models\ReceiptQuery;
use backend\models\SellerQuery;
use backend\models\Trader;
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
class ZoneController extends base\TradingController
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
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
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
