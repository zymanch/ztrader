<?php

namespace backend\models;

use backend\models\base\BaseUser;
use Yii;
use yii\web\IdentityInterface;

class User extends BaseUser implements IdentityInterface
{
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const ROLE_TRADER = 'trader';
    const ROLES = [
        self::ROLE_USER,
        self::ROLE_ADMIN,
        self::ROLE_TRADER,
    ];

    /**
     * @return User
     * @throws \yii\base\Exception
     */
    public static function create() {
        $model = new self();
        $model->inputPassword = $model->generatePassword();
        $model->auth_key = $model->generateAuthKey();
        return $model;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email','auth_key'], 'required'],
            ['username', 'match', 'pattern'=>'/^[0-9a-zA-Z_\-.]*$/i', 'message' => 'Only latin characters, numbers, hyphens and underscores are allowed'],
            ['inputPassword', 'required', 'on'=>'create', 'message' => 'Please enter a valid password'],
            [['created','white_ips'], 'safe'],
            [['password','auth_key', 'inputPassword'], 'string', 'max' => 64],
            [['email'], 'string', 'max' => 128],
            [['username'], 'unique'],
            [['username'], 'string', 'min'=>3, 'max' => 15],
            [['auth_key'], 'string', 'min'=>40, 'max' => 100],
            [['email'], 'unique'],
            [['email'], 'email'],
            ['white_ips', 'required'],
            ['white_ips', 'validateWhiteIpList'],
            ['projects',  'required', 'message' => 'Please select at least one project'],
            ['projects',  'validateProjectList'],
            ['role', 'in', 'range' => User::ROLES],
        ];
    }



    private $inputPassword;


    /**
     * @param $inputPassword
     */
    public function setInputPassword($inputPassword) {
        $this->inputPassword = $inputPassword;
        if ($inputPassword != '') {
            $this->password = $this->_makePasswordHash($inputPassword);
        }
    }

    /**
     * @return mixed
     */
    public function getInputPassword() {
        return $this->inputPassword;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->inputPassword != '') {
            $this->updateAttributes([
                'password' => $this->_makePasswordHash($this->inputPassword)
            ]);
        }
        parent::afterSave($insert, $changedAttributes);
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'created' => 'Created',
            'white_ips' => 'White IPs',
            'role' => 'Role'
        ];
    }


    /**
     * @return array
     */
    public function getWhiteIps() {
        if (!$this->white_ips) {
            return [];
        }
        return array_filter(explode(',', $this->white_ips));
    }

    public static function findIdentity($id) {
        return self::find()->where('user_id = :id', [':id' => $id])->one();
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
     * @return string
     * @throws \yii\base\Exception
     */
    public function generatePassword()
    {
        return Yii::$app->getSecurity()->generateRandomString(10);
    }

    public function generateAuthKey()
    {
        return sha1($this->generatePassword());
    }


    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId() {
        return $this->user_id;
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password) {
        return $this->password === $this->_makePasswordHash($password);
    }

    /**
     * @param $password
     * @return string
     */
    private function _makePasswordHash($password) {
        return sha1($password.$this->user_id.\Yii::$app->params['salt_for_user']);
    }

    /**
     * @param $attribute
     */
    public function validateWhiteIpList ($attribute, $params, $validator) {
        $this->white_ips = preg_replace('/\s+/', '',  $this->white_ips);
        $ips = explode(',', $this->white_ips);
        foreach ($ips as $ip) {
            if (! filter_var($ip, FILTER_VALIDATE_IP)) {
                $this->addError($attribute, 'Please provide a list of valid IP addresses.');
                break;
            }
        }
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return explode(',' , $this->role);
    }

    public function isAdmin()
    {
        return in_array(self::ROLE_ADMIN, $this->getRoles(), true);
    }

    public function isTrader()
    {
        return in_array(self::ROLE_TRADER, $this->getRoles(), true);
    }

    public function isUser()
    {
        return in_array(self::ROLE_USER, $this->getRoles(), true);
    }
}
