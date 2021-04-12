<?php
namespace backend\commands;

use ActiveGenerator\Criteria;
use backend\components\buyer;
use backend\components\seller;
use backend\components\repository\Course;
use backend\models\BuyerQuery;
use backend\models\Trader;
use backend\models\TraderHistory;
use backend\models\TraderHistoryQuery;
use backend\models\TraderImitation;
use backend\models\TraderImitationQuery;
use backend\models\TraderQuery;
use backend\models\User;
use yii\console\Controller;
use yii\helpers\Console;

class UserController extends Controller {

    public $defaultAction = 'create';

    public $username;
    public $email;
    public $password;
    public $role = 'receipt,traider';

    public function options($actionID)
    {
        switch ($actionID) {
            case 'create':
                return ['username','email','role','password'];
            default:
                return [];
        }

    }

    public function actionCreate()
    {
        $user = new User();
        $user->role = $this->role;
        $user->password =$this->password;
        $user->email =$this->email;
        $user->username =$this->username;
        $user->auth_key = \Yii::$app->security->generateRandomString(64);
        if (!$user->save()) {
            throw new \Exception('Ошибка создания юзера: '.json_encode($user->getErrors()));
        }
        $user->setInputPassword($this->password);
        $user->save(false);
        $this->stdout('Юзер успешно создан');
    }

}