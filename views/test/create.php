<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Speek */

$this->title = Yii::t('app', 'Create Speek');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Speeks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speek-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
