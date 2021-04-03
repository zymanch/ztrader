<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components\control;

use backend\models\User;
use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class WhiteIp extends ActionFilter
{


    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return $this->_checkGuestAccess();
        }
        return $this->_checkUserAccess();
    }

    protected function _checkUserAccess() {
        if ($this->_userHasAccess()) {
            return true;
        }
        $this->denyAccess();
        return false;
    }

    protected function _checkGuestAccess() {
        if ($this->_userHasAccess()) {
            return true;
        }
        $this->denyAccess();
        return false;
    }

    protected function _userHasAccess() {
        return true;
        $userIp = Yii::$app->request->getRemoteIP();
        foreach ([] as $whiteIp) {
            if ($userIp === $whiteIp) {
                return true;
            }
        }
        return false;
    }

    protected function denyAccess()
    {
        throw new ForbiddenHttpException(
            Yii::t('yii',
                'You are not allowed to access from this IP:'.Yii::$app->request->getRemoteIP().
                "Perhaps your IP wasn't added to white IP list. If you think you should have access to this page, please contact administrators"
            )
        );
    }
}
