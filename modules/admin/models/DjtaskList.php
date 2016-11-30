<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "djtask_list".
 *
 * @property integer $taskId
 * @property string $taskNo
 * @property string $taskfiles
 * @property string $taskstate
 * @property string $reporterId
 * @property string $reporttime
 * @property string $approverId
 * @property string $approvertime
 * @property string $year
 * @property string $taskcontent
 */
class DjtaskList extends \yii\db\ActiveRecord
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
            [['taskNo'], 'string', 'max' => 14],
            [['taskfiles'], 'string', 'max' => 5000],
            [['taskstate'], 'string', 'max' => 2],
            [['reporterId'], 'string', 'max' => 12],
            [['reporttime', 'approverId', 'approvertime'], 'string', 'max' => 20],
            [['year'], 'string', 'max' => 4],
            [['taskcontent'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'taskId' => 'Task ID',
            'taskNo' => 'Task No',
            'taskfiles' => 'Taskfiles',
            'taskstate' => 'Taskstate',
            'reporterId' => 'Reporter ID',
            'reporttime' => 'Reporttime',
            'approverId' => 'Approver ID',
            'approvertime' => 'Approvertime',
            'year' => 'Year',
            'taskcontent' => 'Taskcontent',
        ];
    }
}
