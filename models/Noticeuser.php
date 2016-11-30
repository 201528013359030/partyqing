<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "noticeuser".
 *
 * @property integer $id
 * @property string $eid
 * @property string $uid
 * @property string $name
 * @property string $mobile
 * @property integer $time
 * @property integer $level
 */
class Noticeuser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'noticeuser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eid', 'uid', 'name', 'mobile', 'time', 'level'], 'required'],
            [['time', 'level'], 'integer'],
            [['eid', 'uid', 'name', 'mobile'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eid' => 'Eid',
            'uid' => 'Uid',
            'name' => '姓名',
            'mobile' => '电话',
            'time' => 'Time',
            'level' => 'Level',
        ];
    }
}
