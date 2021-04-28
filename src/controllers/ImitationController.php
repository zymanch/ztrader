<?php

namespace backend\controllers;


use ActiveGenerator\Criteria;
use backend\models\forms\ImitationForm;
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
class ImitationController extends base\TradingController
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
                        'actions' => ['index','create', 'view','status','history'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex() {
        $imitations = $this->_getImitations();
        return $this->render('index', [
            'imitations' => $imitations
        ]);
    }

    public function actionStatus() {
        $this->response->format = Response::FORMAT_JSON;
        $result = [];
        $imitations = $this->_getImitations();
        foreach ($imitations as $imitation) {
            $result[] = [
                'imitation_id'=>$imitation->trader_imitation_id,
                'status'=>$imitation->status,
                'progress'=>$imitation->progress,
                'income'=>$imitation->getMonthlyIncome(),
            ];
        }
        return ['status'=>'ok','items'=>$result];
    }

    private function _getImitations()
    {
        return TraderImitationQuery::model()
            ->orderByStatus()
            ->orderByTraderImitationId()
            ->all();
    }

    public function actionCreate($trader_id=null)
    {
        $model = new ImitationForm;
        $model->trader_id = $trader_id ? (int)$trader_id : null;
        $request = \Yii::$app->request;
        if ($request->isPost && $model->load($request->post()) && $model->validate() && $model->create()) {
            $this->successFlash('Имитация успешно создана');
            return $this->redirect(['imitation/index']);
        }
        return $this->render('create', [
            'model'=>$model
        ]);
    }

    public function actionView(int $id)
    {
        $model = TraderImitationQuery::model()
            ->filterByTraderImitationId($id)
            ->one();
        if (!$model) {
            throw new NotFoundHttpException();
        }
        return $this->render('view', [
            'model'=>$model
        ]);
    }

    public function actionHistory(int $id, int $history_id) {
        $model = TraderImitationQuery::model()
             ->filterByTraderImitationId($id)
             ->one();
        if (!$model) {
            throw new NotFoundHttpException();
        }
        $history = $model->getTraderHistories()->filterByTraderHistoryId($history_id)->one();
        if (!$history) {
            throw new NotFoundHttpException();
        }
        return $this->render('history', [
            'model'=>$model,
            'history' => $history
        ]);
    }
}
