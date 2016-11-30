<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enterpris".
 *
 * @property integer $id
 * @property integer $enterpris_id
 * @property string $eid
 * @property string $ip
 * @property integer $time
 */
class Enterpris extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice.enterpris';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enterpris_id', 'eid', 'ip', 'time'], 'required'],
            [['enterpris_id', 'time'], 'integer'],
            [['eid'], 'string', 'max' => 30],
            [['ip'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'enterpris_id' => 'Enterpris ID',
            'eid' => 'Eid',
            'ip' => 'Ip',
            'time' => 'Time',
        ];
    }
}
