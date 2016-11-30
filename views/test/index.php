<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Speeks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speek-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Speek'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'talkurl:url',
            'zan',
            'createtime',
            'picurl:url',
            // 'readd',
            // 'fileName',
            // 'size',
            // 'timesize',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
