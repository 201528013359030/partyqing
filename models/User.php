<?php

namespace app\models;

use app\models\AdminInfo;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
     //   return isset(self::$users['100']) ? new static(self::$users['100']) : null;
        $res = AdminInfo::find()->where(['id'=>$id])->one();
        $user = null;
        if($res){
            $user['id'] = $res['id'];
            $user['username'] = $res['user'];
            $user['password'] = $res['password'];
            $user['authKey'] = $res['authKey'];
            $user['accessToken'] = $res['accessToken'];
        }
        return new static($user);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $res = AdminInfo::find()->where(['accessToken'=>$token])->one();
        $user = null;
        if($res){
            $user['id'] = $res['id'];
            $user['username'] = $res['username'];
            $user['password'] = $res['password'];
            $user['authKey'] = $res['authKey'];
            $user['accessToken'] = $res['accessToken'];
        }
        return new static($user);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $res = AdminInfo::find()->where(['user'=>$username])->one();
        $user = null;
        if($res){
            $user['id'] = $res['id'];
            $user['username'] = $res['user'];
            $user['password'] = $res['password'];
            $user['authKey'] = $res['authKey'];
            $user['accessToken'] = $res['accessToken'];
        }
        return new static($user);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
}
