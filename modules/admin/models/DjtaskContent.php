<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "djtask_content".
 *
 * @property integer $taskNo
 * @property string $content
 * @property string $starttime
 * @property string $endtime
 * @property string $suporting
 * @property string $listid
 * @property string $year
 * @property string $flag
 * @property string $parentid
 * @property string $taskclassify
 * @property string $adminid
 * @property string $companyuid
 */
class DjtaskContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'djtask_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adminid', 'companyuid'], 'required'],
            [['content'], 'string', 'max' => 64],
            [['starttime', 'endtime'], 'string', 'max' => 24],
            [['suporting'], 'string', 'max' => 164],
            [['listid'], 'string', 'max' => 12],
            [['year'], 'string', 'max' => 4],
            [['flag'], 'string', 'max' => 1],
            [['parentid'], 'string', 'max' => 14],
            [['taskclassify'], 'string', 'max' => 50],
            [['adminid', 'companyuid'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'taskNo' => 'Task No',
            'content' => 'Content',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
            'suporting' => 'Suporting',
            'listid' => 'Listid',
            'year' => 'Year',
            'flag' => 'Flag',
            'parentid' => 'Parentid',
            'taskclassify' => 'Taskclassify',
            'adminid' => 'Adminid',
            'companyuid' => 'Companyuid',
        ];
    }
}
