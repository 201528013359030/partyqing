<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<title>公告</title>
    <?php $this->head() ?>
</head>
<style >

	.nav-pills > li > a {
	color: #222; 
	border-radius: 0px;
	padding: 7px 0px;
	padding-left: 65px;
	font-family: "Helvetica Neue","Hiragino Sans GB","Microsoft YaHei","\9ED1\4F53",Arial,sans-serif;
	}
	.nav-pills > li.active > a,
	.nav-pills > li.active > a:hover,
	.nav-pills > li.active > a:focus {
	background-color: #3076C2;
	}
	.nav-font-1{
		font-size: 15px;
		font-weight: bold;
		color: #9C9C9C;
		vertical-align: middle;
	}
	.nav-stacked > li + li{
		margin-top:0px;
	}
</style>
<body>
<?php $this->beginBody() ?>
<div style="  background: #e7e8eb;">
	<div class="row" style="margin-right:0px;background-color:#3076C2;height:50px;">
		<div class="col-md-1"> 
		</div> 
		<div class="col-md-9">
		</div>
		<div class="col-md-2">
			<div class="nav-font-1" style="color:#ffffff;padding-top:20px;padding-left:5px;" >
				<?//=(Yii::$app->user->isGuest ?null:Yii::$app->user->identity->username)?>
				<?=Yii::$app->session['user.pname']?>
				<a href="/notice/web/index.php?r=admin/index/logout" data-method="post" style="color:#ffffff;padding-left:8px;">退 出</a>
			</div>
		</div>  
	</div>
	<div class="row" style="min-height:700px;width:1200px;margin:20px 0px 50px;background:#ffffff; margin-left:auto;margin-right: auto;border:1px solid #e1e1e1;">
		<div class="col-md-2" style="padding:0px"> 
			<div style="min-height:700px;border-right:1px solid #e1e1e1;padding-top:15px;">
				<?php foreach (Yii::$app->params['menu'] as $mk=>$menu):?>
				<div>
					<div style="height:44px;padding-top:10px;">
						<div class="nav-font-1" style="padding-left:30px;">
							<img src=<?=$menu['img']?> height="30" width="30" style="vertical-align: middle;">
							<span style="vertical-align: middle;"><?=$menu['main']?></span>
						</div>
					</div>
					<ul class="nav nav-pills nav-stacked">
						<?php foreach ($menu['sub'] as $sk=>$sub): ?>
						<li id=<?=$mk.$sk?>><a href=<?=$sub['url'].'&subflag='.$mk.$sk?>><?=$sub['name']?></a></li>
						<? endforeach?>
					</ul>
				</div>
				<? endforeach?>
			</div>
		</div> 

		<div class="col-md-10" style="font-family: Helvetica Neue,Hiragino Sans GB,Microsoft YaHei,\9ED1\4F53,Arial,sans-serif;">
			<?php echo $content; ?>
		</div>
	</div>
</div>
<?php $this->endBody() ?>
</body>
<script>
$(function(){
	var subflag = "<?=(Yii::$app->request->get('subflag')?Yii::$app->request->get('subflag'):'0101') ?>";
	$("#"+subflag).attr("class","active");
});

	
</script>
</html>
<?php $this->endPage() ?>
