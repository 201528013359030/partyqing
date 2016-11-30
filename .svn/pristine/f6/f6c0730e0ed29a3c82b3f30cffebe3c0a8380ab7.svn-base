<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>

<div class="container" style=" padding-top: 120px;">
    <div class="row">
        <div class="col-md-4 sm col-sm-1"></div>
        <div class="col-md-4 sm col-sm-1 login">
            <?php $form=ActiveForm::begin([
                'id'=>'login',
                'enableAjaxValidation' => false,
                'options'=>['enctype'=>'multipart/form-data']
            ]);?>

            <?=$form->field($model,'username')->textInput(["placeholder"=>"账号"]); ?>
            <?=$form->field($model,'password')->passwordInput(['placeholder'=>'密码']); ?>
            <?if(YII_ICT):?>
            <div style="display:#none">
            <?else:?>
            <div style="display:none">
            <?endif?>
            <?=$form->field($model,'eid')->textInput(['placeholder'=>'企业ID']); ?>
            </div>
            <!--?//=$form->field($model,'verifyCode')->widget(Captcha::className(),['captchaAction'=>Yii::$app->urlManager->createUrl('image/captcha'),
//                'template'=>'<div class="row"><div class="col-md-3 col-xs-4 mr20">{image}</div><div class="col-md-6 col-xs-6">{input}</div></div>'
//            ])?-->

            <?= $form->field($model, 'rememberMe', [
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ])->checkbox() ?>
            <?=  Html::submitButton('登录', ['class'=>'btn btn-primary btn-lg btn-block','name' =>'submit-button']) ?>
            <?php ActiveForm::end();?>
        </div>
        <div class="col-md-4 sm col-sm-1"></div>
    </div>
</div>

