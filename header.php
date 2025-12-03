<?php
/*
Template Name:NullTwo<div class="NullTwoSet"><br /><a href="../?setting" target="_blank">模板设置</a>&nbsp;<a href="https://www.tongleer.com/api/web/pay.png" target="_blank">打赏</a>&nbsp;<a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=diamond0422@qq.com" target="_blank">反馈</a>&nbsp;<span id="NullTwoUpdateinfo"></span></div><style>.NullTwoSet a{background: #4DABFF;padding: 5px;color: #fff;}</style><script>NullTwoXmlHttp=new XMLHttpRequest();NullTwoXmlHttp.open("GET","https://www.tongleer.com/api/interface/NullTwo.php?action=update&version=1",true);NullTwoXmlHttp.send(null);NullTwoXmlHttp.onreadystatechange=function () {if (NullTwoXmlHttp.readyState ==4 && NullTwoXmlHttp.status ==200){document.getElementById("NullTwoUpdateinfo").innerHTML=NullTwoXmlHttp.responseText;}}</script>
Description:空值二开，进阶模板，适合自媒体用户。
Version:3.0.1
ForEmlog:6.1.1
Author:二呆(VX:Diamond0422)
Author Url:https://www.tongleer.com
Sidebar Amount:2
*/
$Theme_Version="3.0.1";
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
require_once View::getView('ajax');
if(!defined('ADMIN_DIR')) {define("ADMIN_DIR",$NullTwoOption["admin_dir"]?$NullTwoOption["admin_dir"]:"admin");}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
	<title><?php echo $site_title; ?></title>
	<meta name="keywords" content="<?php echo $site_key; ?>" />
	<meta name="description" itemprop="description" content="<?php echo $site_description; ?>" />
	<meta name="generator" content="emlog" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="x-dns-prefetch-control" content="on">
	<meta http-equiv="Cache-Control" content="no-transform"/>
	<meta http-equiv="Cache-Control" content="no-siteapp"/>
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<meta name="theme-color" content="<?php echo $NullTwoOption["webpage_color"]?$NullTwoOption["webpage_color"]:"#009688"; ?>">
	<meta name="author" content="二呆,diamond0422@qq.com">
	<meta property="og:type" content="blog"/>
	<meta property="og:image" content="https://www.tongleer.com/wp-content/themes/tongleer/assets/images/w-logo-blue.png"/>
	<meta property="og:title" content="><?php echo $site_title; ?></"/>
	<meta property="og:description" content="<?php echo $site_description; ?>"/>
	<meta property="og:author" content="二呆,diamond0422@qq.com"/>
	<meta itemprop="name" content="><?php echo $site_title; ?></"/>
	<meta itemprop="image" content="https://www.tongleer.com/wp-content/themes/tongleer/assets/images/w-logo-blue.png" />
	<?php if($NullTwoOption["is_referrer"]=="y"){?>
	<meta name="referrer" content="same-origin">
	<?php }?>
	<link rel="dns-prefetch" href="<?php echo TEMPLATE_URL; ?>"/>
	<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
	<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
	<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
	<link type="image" href="https://me.tongleer.com/content/templates/dux/images/favicon.png" rel="shortcut icon">
	<link rel="apple-touch-icon" href="https://me.tongleer.com/content/templates/dux/images/favicon.png">
	
	<link href="<?php echo TEMPLATE_URL; ?>style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo TEMPLATE_URL; ?>assets/css/baguetteBox.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo TEMPLATE_URL; ?>assets/icomoon/style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo TEMPLATE_URL; ?>assets/css/prism.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo TEMPLATE_URL; ?>assets/css/hint.css" rel="stylesheet" type="text/css" />
	<!--
	<script type='text/javascript' src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type='text/javascript' src='//cdn.jsdelivr.net/npm/pjax@0.2.6/pjax.min.js'></script>
	-->
	<script type='text/javascript' src="<?php echo TEMPLATE_URL; ?>assets/js/jquery.min.js"></script>
	<script type='text/javascript' src="<?php echo TEMPLATE_URL; ?>assets/js/jquery.cookie.js"></script>
	<script type='text/javascript' src='<?php echo TEMPLATE_URL; ?>assets/js/pjax.min.js'></script>
	<script type='text/javascript' src="<?php echo TEMPLATE_URL; ?>assets/js/prism.js"></script>
	<!--[if lt IE 9]>
	<script src="//cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
	<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style type="text/css">
	html{--accent-color:<?php echo $NullTwoOption["webpage_color"]?$NullTwoOption["webpage_color"]:"#009688"; ?>}
	</style>
	<style>
	.f-head .f-img,#links .list-item .cover {
		background: none;
		padding: 0;
	}
	</style>
	<style type="text/css">
	body {
		background: #f9f9ff;
	}
	.header,.style{
		box-shadow: none;
	}
	.f-head .f-img img {
		border-radius: 5px;
	}
	.f-img i {
		display: none;
	}
	.banner {
		height: 560px;
		margin-bottom: -140px;
	}
	.container {
		z-index: 1;
		position: relative;
	}
	#notification{
		z-index: 1;
	}
	#mobilebar.t_color .inner {
	background: <?php echo $NullTwoOption["webpage_color"]?$NullTwoOption["webpage_color"]:"#009688"; ?>;
	background: -webkit-linear-gradient(to right,<?php echo $NullTwoOption["webpage_color_sub"]?$NullTwoOption["webpage_color_sub"]:"#9c51ff"; ?>,<?php echo $NullTwoOption["webpage_color"]?$NullTwoOption["webpage_color"]:"#009688"; ?>); 
	background: linear-gradient(to right,#9c51ff,<?php echo $NullTwoOption["webpage_color"]?$NullTwoOption["webpage_color"]:"#009688"; ?>);
	}

	@media(max-width: 560px){
	.style {
		border-radius: 5px;
		margin-bottom: 10px;
	}
	.main-list {
		padding: 0 10px;
	}
	}
	</style>
	<style>
	video,iframe{width:100%;}
	</style>
	<?php doAction('index_head'); ?>
	<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>assets/js/wangEditor.min.js"></script>
</head>
<body>
<!--[if lt IE 9]>
    <script type="text/javascript">
        var str = '<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，此网站框架暂不支持。 请 <a href="https://browsehappy.com/" target="_blank">升级浏览器</a>以获得更好的体验！</p>';
        document.writeln("<pre style='text-align:center;color:#fff;background-color:#0cc; height:100%;border:0;position:fixed;top:0;left:0;width:100%;z-index:1234'>" +
                "<h2 style='padding-top:200px;margin:0'><strong>" + str + "<br/></strong></h2><h2 style='margin:0'><strong>如果你的使用的是双核浏览器,请切换到极速模式访问<br/></strong></h2></pre>");
        document.execCommand("Stop");
    </script>
<![endif]-->
<div class="bg"></div><!-- 特别背景 -->
<!-- 手机侧栏导航 -->
<?php include View::getView('side'); ?>
<!-- end -->
<a href="javascript:(0);" class="header-off off-overlay"></a>

<section id="main">
	<header class="header">
	  <div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
	  <section id="mobilebar" class="t_color">
		<div class="inner">
			<div class="col back"><a href="javascript:void(0);" class="header-btn"><span class="icon Q-menu"></span></a></div>
			<div class="col title"><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></div>
			<div class="col switch"><a href="javascript:;" class="js-toggle-search"><span class="icon Q-search"></span></a></div>
		</div>
	  </section>
	  <form class="js-search search-form" method="get" action="<?php echo BLOG_URL; ?>" role="search">
		<div class="search-form-inner">
			<div>
				<i class="icon Q-search"></i>
				<input class="text-input" type="search" name="keyword" placeholder="想要什么，就搜什么" autocomplete="off">
			</div>
		</div>
		<?php if($NullTwoOption["user_login_switch"]=="y"){?>
		<div class="style user-item">
		  <div class="user_info">
			<li class=""><span><a href="<?=BLOG_URL;?>?user&publish">发布动态</a></span></li>
			<li class=""><span>&nbsp;</span></li>
			<li class="vitnum"><span><a href="<?=BLOG_URL;?>?user">会员中心</a></span></li>
		  </div>
		</div>
		<?php }?>
	  </form>

	  <div class="width">
		<div class="menu">
		  <h1 class="logo"><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1>
		  <nav class="nav">
			<ul>
				<?php blog_navi();?>
			</ul>
		  </nav>
		</div>
	  </div>
	  <?php if($NullTwoOption["home_pic_switch"]=="y"){?>
	  <section class="banner bg" style="background-image: url(<?php echo $NullTwoOption["home_pic_url"]?$NullTwoOption["home_pic_url"]:TEMPLATE_URL."images/post.jpg"; ?>);" data-time="8000">
		<?php
		$home_pic_other=explode("|",$NullTwoOption["home_pic_other"]);
		if($home_pic_other){
			$home_pic_other_i=0;foreach($home_pic_other as $value){
			?>
			<div id="banner-data" style="display:none">
				<img id="banner-<?=$home_pic_other_i;?>" src="<?=$value;?>">
			</div>
			<?php
			$home_pic_other_i++;}
		}
		?>
	  </section>
	  <?php }?>
	</header>
	<!-- header -->

	<div class="container">
	  <div class="width">
		<div class="main">
		  <?php include View::getView('side_left'); ?>
		  <!-- main-left -->	  
		  <div class="main-central main-mod">