<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "announce".
 *
 * @property integer $announce_id
 * @property integer $type
 * @property string $title
 * @property string $content
 * @property string $attach
 * @property string $sender
 * @property integer $comment_switch
 * @property integer $enterpris_id
 * @property integer $time
 */
class Announce extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'announce';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'title', 'content', 'attach', 'sender', 'comment_switch', 'enterpris_id', 'time'], 'required'],
            [['type', 'comment_switch', 'enterpris_id', 'time', 'confirmNum'], 'integer'],
            [['title', 'sender'], 'string', 'max' => 100],
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
            'title' => 'Title',
            'content' => 'Content',
            'attach' => 'Attach',
            'sender' => 'Sender',
            'comment_switch' => 'Comment Switch',
            'enterpris_id' => 'Enterpris ID',
            'time' => 'Time',
        ];
    }
}
