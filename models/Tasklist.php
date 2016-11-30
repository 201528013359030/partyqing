<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "noticeinfo".
 *
 * @property integer $announce_id
 * @property integer $type
 * @property string $title
 * @property string $content
 * @property string $attach
 * @property string $sender
 * @property string $reveicer
 * @property integer $comment_switch
 * @property integer $enterpris_id
 * @property integer $time
 * @property integer $confirmNum
 */
class Tasklist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'djtask_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['taskNo'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'taskId' => 'taskId',
            'taskNo' => 'taskNo',
            'taskfiles' => 'taskfiles',
            'taskcontent' => 'taskcontent',
            'taskstate' => 'taskstate',
            'reporterId' => 'reporterId',
            'reporttime' => 'reporttime',
            'approverId' => 'approverId',
            'approvertime' => 'approvertime',
            'year' => 'year',          

        ];
    }
}
