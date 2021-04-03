<?php

namespace backend\controllers;


use ActiveGenerator\Criteria;
use backend\models\forms\UploadReceiptForm;
use backend\models\Receipt;
use backend\models\ReceiptQuery;
use backend\models\UserReceipt;
use backend\models\UserReceiptQuery;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
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
                        'actions' => ['index','create','view','scanned','unusable','skip'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $receipt = $this->_getReceipt();
        return $this->render('index', [
            'receipt' => $receipt,
        ]);
    }

    public function actionView($id)
    {
        $receipt = ReceiptQuery::model()->filterByReceiptId($id)->one();
        if (!$receipt) {
            throw new NotFoundHttpException('Чек не найден');
        }
        $qrCode = $this->_getQrCode($receipt);
        if (!$qrCode) {
            throw new \RuntimeException('Ошибка генерации чека');
        }
        \Yii::$app->response->format = Response::FORMAT_RAW;
        header("Content-Type: image/png");
        return $qrCode;
    }

    public function actionScanned($id) {
        $this->_markReceipt($id, UserReceipt::STATUS_USED);
        return $this->redirect(['receipt/index']);
    }
    public function actionUnusable($id) {
        $this->_markReceipt($id, UserReceipt::STATUS_UNUSABLE);
        return $this->redirect(['receipt/index']);
    }
    public function actionSkip($id) {
        $this->_markReceipt($id, UserReceipt::STATUS_SKIPPED);
        return $this->redirect(['receipt/index']);
    }

    private function _markReceipt($receiptId, $status)
    {
        $receipt = ReceiptQuery::model()->filterByReceiptId($receiptId)->one();
        if (!$receipt) {
            throw new NotFoundHttpException('Чек не найден');
        }
        $userId = \Yii::$app->user->id;
        $link = $receipt->getUserReceipts()->filterByUserId($userId)->one();
        if (!$link) {
            $link = new UserReceipt();
            $link->user_id = $userId;
            $link->receipt_id = $receipt->receipt_id;
        }
        $link->status =$status;
        $link->save(false);
    }

    private function _getReceipt()
    {
        $userId = \Yii::$app->user->id;
        return ReceiptQuery::model()
            ->orderByDate()
            ->filterByDate(date('Y-m-d 00:00:00',time()-3600*24*3),Criteria::GREATER_THAN)
            ->joinWithUserReceipts(function(UserReceiptQuery $query) use ($userId) {
                $query
                    ->filterByUserReceiptId(null)
                    ->andOnCondition(['=','user_receipt.user_id',$userId]);
            })
            ->andWhere('(receipt.user_id='.$userId.' or receipt.created > adddate(now(),interval 1 hour))')
            ->one();
    }

    private function _getQrCode(Receipt $receipt = null)
    {
        if (!$receipt) {
            return '';
        }
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        return $writer->writeString($receipt->qr_code);
    }

    public function actionCreate()
    {
        $form = new UploadReceiptForm;
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $form->receipt = UploadedFile::getInstance($form, 'receipt');
            $form->user_id = \Yii::$app->user->id;
            try {
                $form->createReceipt();
                $this->successFlash('Чек успешно добавлен');
            } catch (\Exception $e) {
                $this->successFlash('Ошибка добавления чека: '.$e->getMessage());
            }
            return $this->redirect(['receipt/create']);
        }
        return $this->render('create', [
            'model' => $form
        ]);
    }

}