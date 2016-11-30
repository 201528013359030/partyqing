<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "djtask_assign".
 *
 * @property integer $id
 * @property string $source_uid
 * @property string $goal_uid
 * @property integer $task
 */
class DjtaskAssign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'djtask_assign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_uid', 'goal_uid', 'task'], 'required'],
            [['task'], 'integer'],
            [['source_uid', 'goal_uid'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source_uid' => 'Source Uid',
            'goal_uid' => 'Goal Uid',
            'task' => 'Task',
        ];
    }
}
