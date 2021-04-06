<?php
namespace backend\controllers;

use backend\components\control\WhiteIp;
use Yii;

/**
 * Supercontroller class
 */
abstract class Controller extends \yii\web\Controller
{

    public $menuItemList = [];
    public $mainLink = '/';


    public function init() {
        parent::init();
        $this->menuItemList = $this->_prepareMenu();
        $this->mainLink = $this->_getMainLink();

    }


    public function behaviors() {
        return [
            'white_ip' => [
                'class' => WhiteIp::className(),
            ],
        ];
    }

    /**
     * Prepare menu items
     *
     * @return array
     */
    protected function _prepareMenu()
    {
        return [
            [
                'label' => 'Чеки',
                'url'   => [
                    'receipt/index',
                ]
            ],
            [
                'label' => 'Трейдинг',
                'url'   => [
                    'trader/index',
                ]
            ],
        ];
    }

    protected function _getMainLink()
    {
        $currentQueryParams = Yii::$app->request->getQueryParams();
        $params = http_build_query($currentQueryParams);
        return '/' . (!empty($params) ? '?' . $params : '');
    }

    protected function successFlash($message) {
        Yii::$app->session->addFlash('success',$message);
    }

    protected function errorFlash($message) {
        Yii::$app->session->addFlash('error', $message);
    }
}