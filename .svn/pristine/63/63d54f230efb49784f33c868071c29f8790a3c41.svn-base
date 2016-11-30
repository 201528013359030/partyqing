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
class Noticeinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'noticeinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'title', 'content', 'attach', 'sender', 'comment_switch', 'enterpris_id', 'time', 'receiverType'], 'required'],
            [['type', 'comment_switch', 'time', 'confirmNum', 'receiverType','confirm', 'top_time','top_day'], 'integer'],
            [['title', 'sender', 'enterpris_id', 'sender_name'], 'string', 'max' => 100],
            [['content'], 'string', 'max' => 5000],
            [['attach'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'announce_id' => 'Announce ID',
            'type' => 'Type',
            'title' => '标题',
            'content' => 'Content',
            'attach' => 'Attach',
            'sender' => 'Sender',
            'reveicer' => 'Reveicer',
            'comment_switch' => '置顶级别',
            'enterpris_id' => 'Enterpris ID',
            'time' => '发布时间',
            'confirmNum' => 'Confirm Num',
            'sender_name' => '发布者',
            'receiverType' => '接收人类型',
            'top_day' => '置顶天数',

        ];
    }
}
