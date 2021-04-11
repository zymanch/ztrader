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
                        'actions' => ['index','create','view','update','seller','buyer','delete'],
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

    public function actionCreate()
    {
        $model = new Trader;
        $model->seller_id = SellerQuery::SELLER_ID_NONE;
        $model->seller_options = '{}';
        $model->buyer_id = BuyerQuery::BUYER_ID_NONE;
        $model->buyer_options = '{}';
        $model->state_date = date('Y-m-d H:i:s');
        $request = \Yii::$app->request;
        if ($request->isPost && $model->load($request->post()) && $model->validate() && $model->save()) {
            $this->successFlash('Инструмент успешно создан');
            return $this->redirect(['trader/view','id'=>$model->trader_id]);
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }
    public function actionSeller(int $id, int $seller_id = null)
    {
        $trader = TraderQuery::model()->filterByTraderId($id)->one();
        if (!$trader) {
            throw new NotFoundHttpException('Трейдер не найден');
        }
        if ($seller_id) {
            $trader->seller_id = $seller_id;
        }
        $fabric = new \backend\components\seller\Fabric;
        $seller = $fabric->create($trader->seller_id, $trader->currency_id, $trader->getSellerOptions());

        $request = \Yii::$app->request;
        if ($request->isPost && $seller->load($request->post()) && $seller->validate()) {
            $trader->seller_options = json_encode($seller->getAttributes());
            $trader->save(false);
            $this->successFlash('Продавец успешно сохранен');
            return $this->redirect(['trader/view','id'=>$trader->trader_id]);
        }
        return $this->render('seller', [
            'model' => $trader,
            'seller' => $seller,
        ]);
    }

    public function actionBuyer(int $id, int $buyer_id = null)
    {
        $trader = TraderQuery::model()->filterByTraderId($id)->one();
        if (!$trader) {
            throw new NotFoundHttpException('Трейдер не найден');
        }
        if ($buyer_id) {
            $trader->buyer_id = $buyer_id;
        }
        $fabric = new \backend\components\buyer\Fabric;
        $bayer = $fabric->create($trader->buyer_id, $trader->currency_id, $trader->getBuyerOptions());

        $request = \Yii::$app->request;
        if ($request->isPost && $bayer->load($request->post()) && $bayer->validate()) {
            $trader->buyer_options = json_encode($bayer->getAttributes());
            $trader->save(false);
            $this->successFlash('Покупатель успешно сохранен');
            return $this->redirect(['trader/view','id'=>$trader->trader_id]);
        }

        return $this->render('buyer', [
            'model' => $trader,
            'bayer' => $bayer,
        ]);
    }
    public function actionUpdate(int $id)
    {
        $model = TraderQuery::model()->filterByTraderId($id)->one();
        if (!$model) {
            throw new NotFoundHttpException('Трейдер не найден');
        }
        $request = \Yii::$app->request;
        if ($request->isPost && $model->load($request->post()) && $model->validate() && $model->save()) {
            $this->successFlash('Инструмент успешно сохранен');
            return $this->redirect(['trader/view','id'=>$model->trader_id]);
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete(int $id, $confirm = null)
    {

        $model = TraderQuery::model()->filterByTraderId($id)->one();
        if (!$model) {
            throw new NotFoundHttpException('Трейдер не найден');
        }
        if ($confirm) {
            $model->delete();
            $this->successFlash('Инструмент успешно удален');
            return $this->redirect(['trader/index']);
        }
        return $this->render('delete', [
            'model' => $model
        ]);
    }

}
