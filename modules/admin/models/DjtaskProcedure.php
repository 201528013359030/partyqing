<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "djtask_procedure".
 *
 * @property integer $No
 * @property string $taskId
 * @property string $uid
 * @property string $comment
 * @property string $approvertime
 * @property string $commentcontent
 */
class DjtaskProcedure extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'djtask_procedure';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['taskId'], 'string', 'max' => 14],
            [['uid'], 'string', 'max' => 240],
            [['comment'], 'string', 'max' => 40],
            [['approvertime'], 'string', 'max' => 20],
            [['commentcontent'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'No' => 'No',
            'taskId' => 'Task ID',
            'uid' => 'Uid',
            'comment' => 'Comment',
            'approvertime' => 'Approvertime',
            'commentcontent' => 'Commentcontent',
        ];
    }
}
