<?php

namespace backend\controllers;

use backend\models\forms\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Class LoginController
 *
 * @package backend\controllers
 */
class LoginController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Login
     *
     * @return $this|string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $return_url = $_SESSION['__returnUrl']??null;

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($return_url != null ) {
                return $this->redirect($return_url);
            }
            return $this->goHome();
        } else {
            $this->layout = 'login';
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return Yii::$app->getResponse()->redirect(Url::to(['login/']));
    }

}
