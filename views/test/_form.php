<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Speek */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="speek-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'talkurl')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'zan')->textInput() ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'picurl')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'readd')->textInput() ?>

    <?= $form->field($model, 'fileName')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <?= $form->field($model, 'timesize')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
