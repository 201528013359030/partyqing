<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $uid
 * @property string $relation
 * @property integer $announce_id
 * @property string $photo
 * @property integer $time
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'relation', 'announce_id', 'time'], 'required'],
            [['announce_id', 'time'], 'integer'],
            [['uid', 'relation', 'photo'], 'string', 'max' => 100]
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
            'photo' => 'Photo',
            'time' => 'Time',
        ];
    }
}
