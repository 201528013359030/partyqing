<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "speek".
 *
 * @property integer $id
 * @property string $talkurl
 * @property integer $zan
 * @property string $createtime
 * @property string $picurl
 * @property integer $readd
 * @property string $fileName
 * @property double $size
 * @property double $timesize
 */
class Speek extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'speek';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zan', 'readd'], 'integer'],
            [['createtime'], 'safe'],
            [['size', 'timesize'], 'number'],
            [['talkurl', 'picurl'], 'string', 'max' => 250],
            [['fileName'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'talkurl' => 'Talkurl',
            'zan' => 'Zan',
            'createtime' => 'Createtime',
            'picurl' => 'Picurl',
            'readd' => 'Readd',
            'fileName' => 'File Name',
            'size' => 'Size',
            'timesize' => 'Timesize',
        ];
    }
}
