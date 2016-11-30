<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "noticereader".
 *
 * @property integer $id
 * @property string $uid
 * @property string $relation
 * @property integer $announce_id
 * @property integer $time
 * @property string $confirm
 */
class Noticereader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'noticereader';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'relation', 'announce_id', 'time'], 'required'],
            [['announce_id', 'time'], 'integer'],
            [['uid', 'relation', 'confirm','name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'relation' => 'Relation',
            'announce_id' => 'Announce ID',
            'time' => 'Time',
            'confirm' => 'Confirm',
        ];
    }
}
