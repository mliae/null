<?php 
/**
 * 手机端侧边栏
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="mo-nav" class="bg_vh">
	<div class="_banner bg" style="height:100vh;background-image:url(<?=$NullTwoOption["mobile_side_bg"]?$NullTwoOption["mobile_side_bg"]:TEMPLATE_URL."images/cover.jpg";?>);"></div>
	<div class="m-avatar">
		<span class="time"><i class="icon Q-calendar"></i><?=floor((time()-strtotime($NullTwoOption["website_date"]))/3600/24);?>天</span>
		<i class="icon Q-qrcode qrcode" data-src="<?=$NullTwoOption["info_qrcode"]?$NullTwoOption["info_qrcode"]:"http://p0.so.qhimgs1.com/t0110d41759404ab805.jpg";?>"></i>
		<img src="<?=$NullTwoOption["info_face"]?$NullTwoOption["info_face"]:"https://cambrian-images.cdn.bcebos.com/39ceafd81d6813a014e747db4aa6f0eb_1524963877208.jpeg";?>">
		<span class="name"><?=$NullTwoOption["info_nick"]?$NullTwoOption["info_nick"]:"二呆";?></span>
		<p class="qq_level"><i class="QQlevel i_64"></i><i class="QQlevel i_16"></i><i class="QQlevel i_16"></i><i class="QQlevel i_16"></i><i class="QQlevel i_4"></i><i class="QQlevel i_4"></i><i class="QQlevel i_1"></i></p>
		<p class="nowrap"><?=$NullTwoOption["info_desc"]?$NullTwoOption["info_desc"]:"岂能尽如人意，但求无愧我心。";?>​​</p>
	</div>
	<ul>
		<?php blog_navi();?>
	</ul>
</div>