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
class ImitationController extends Controller
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
                        'actions' => ['index','create', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex() {
        $imitations = TraderImitationQuery::model()
               ->filterByStatus(TraderImitation::STATUS_FINISHED, Criteria::NOT_EQUAL)
               ->orderByStatus()
               ->orderByTraderImitationId()
               ->all();
        return $this->render('index', [
            'imitations' => $imitations
        ]);
    }

    public function actionCreate()
    {
        $model = new ImitationForm;
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
}
