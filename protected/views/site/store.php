<!DOCTYPE HTML>
<html>
	<head>
	<title>Chloé</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="format-detection" content="telephone=no">
	<!--禁用手机号码链接(for iPhone)-->
	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimum-scale=1.0,maximum-scale=1.0,minimal-ui" />
	<!--自适应设备宽度-->
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<!--控制全屏时顶部状态栏的外，默认白色-->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="Keywords" content="">
	<meta name="Description" content="<?php echo $store['name']; ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css" />
	<style type="text/css">
		html,body{
			width: 100%;
			position: relative;
			text-align: center;
			font-family: Microsoft YaHei;
		}
		#box{
			width: 90%;
			display: inline-block;
		}
		.header{
			width: 100%;
			display: inline-block;
			text-align: center;
		}
		.description{
			text-align: left;
			padding: 0 0 10px 0;
		}
		.description h1{
			font-size: 24px;
			padding: 0 0 2px 0;
			color: #000;
		}
		.description ul,.description li{
			width: 100%;
			line-height: 20px;
			font-size: 14px;
		}
		.description li{
			padding: 2px 0;
			color: #767676;
		}
		.description li span{
			width: 25%;
			display: inline-block;
			vertical-align: top;
		}
		.description li p{
			width: 75%;
			display: inline-block;
		}
		.description li p a{
			text-decoration: underline;
		}
		.map{
			padding: 0 0 15px 0;
		}
	</style>
	</head>
	<body>
	<div id="box">
		<header class="header">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.jpg" width="80%" />
		</header>
		<article>
			<section class="description">
				<h1><?php echo $store['name']; ?></h1>
				<ul>
					<li><span>地址：</span><p><?php echo $store['address']; ?></p></li>

					<li><span>营业时间：</span><p><?php echo $store['open']; ?></p></li>

					<li><span>店铺电话：</span><p><a href="tel:<?php echo str_replace(' ', '', $store['telphone']); ?>" ><?php echo $store['telphone']; ?></a></p></li>
				</ul>
			</section>
			<section class="map">
				<img src="<?php echo Yii::app()->request->baseUrl.'/'.$store['mapUrl']; ?>" width="100%" />
			</section>
		</article>
	</div>
	</body>
</html>
