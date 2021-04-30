<?php

namespace backend\controllers;


use ActiveGenerator\Criteria;
use backend\components\buyer\Fabric;
use backend\components\repository\MarketCondition;
use backend\models\BuyerQuery;
use backend\models\Currency;
use backend\models\CurrencyQuery;
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

    public function actionView($id, $date)
    {
        $currency = CurrencyQuery::model()->filterByCurrencyId($id)->one();
        if (!$currency) {
            throw new NotFoundHttpException('Валюта не найден');
        }
        $zones = $this->_getZones($currency, $date);
        return $this->render('view', [
            'currency' => $currency,
            'date' => $date,
            'zones' => array_splice($zones,0,10)
        ]);
    }

    private function _getZones(Currency $currency, $date) {
        $from = new \DateTimeImmutable($date.'-01 00:00:00');
        $to = $from->modify('+1month')->modify('-1 second');
        $condition = new MarketCondition;
        $zones = $condition->getZones(
            $currency->code,
            $from,
            $to
        );
        $previousIsBuy = false;
        $lastIsBuy = false;
        $isAdded = false;
        $addedTimes = 0;
        $result = [];
        foreach ($zones as $zone) {
            $currentIsBuy = $zone['change'] > 0 && $zone['size']==1;;
            if ($previousIsBuy && $lastIsBuy && $currentIsBuy) {
                if ($isAdded) {
                    if ($addedTimes < 5) {
                        $result[count($result) - 1]['to'] = $zone['to'];
                    }
                    $addedTimes++;
                } else {
                    $result[] = $zone;
                    $isAdded = true;
                    $addedTimes = 1;
                }
            } else {
                $isAdded = false;
            }
            $previousIsBuy = $lastIsBuy;
            $lastIsBuy = $currentIsBuy;
        }
        return $result;
    }
}
