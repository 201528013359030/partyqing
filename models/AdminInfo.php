<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $user
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property string $name
 * @property string $thumb
 * @property string $email
 * @property integer $lockAdmin
 * @property integer $lockTime
 * @property integer $enabled
 * @property integer $created_at
 * @property integer $updated_at
 */
class AdminInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user', 'password', 'authKey', 'accessToken', 'name', 'thumb', 'email', 'lockAdmin', 'lockTime', 'enabled', 'created_at', 'updated_at'], 'required'],
            [['id', 'lockAdmin', 'lockTime', 'enabled', 'created_at', 'updated_at'], 'integer'],
            [['user', 'password', 'authKey', 'accessToken', 'name', 'thumb', 'email'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'name' => 'Name',
            'thumb' => 'Thumb',
            'email' => 'Email',
            'lockAdmin' => 'Lock Admin',
            'lockTime' => 'Lock Time',
            'enabled' => 'Enabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
