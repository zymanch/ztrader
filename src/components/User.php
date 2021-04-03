<?php

namespace backend\components;

use backend\models\base\BaseUser;
use yii\web\IdentityInterface;

class User implements IdentityInterface
{

    const ID = 'admin';
    const PASSWORD = 'qwe123';
    const WHITE_IP_LIST = ['127.0.0.1','185.120.71.3'];

    public static function findIdentity($id) {
        return $id == self::ID ? new self : null;
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface
     * @throws \Exception
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new \Exception('Site not support auto authentication system');
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId() {
        return self::ID;
    }

    public function getAuthKey() {
        return self::PASSWORD;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password) {
        return self::PASSWORD === $password;
    }

}
