<?php 
/**
 * 左侧侧边栏
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<aside class="main-left main-mod">
	<div class="style user-item">
	  <div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
	  <div class="user-bg" style="background-image: url(<?php echo $NullTwoOption["home_pic_url"]?$NullTwoOption["home_pic_url"]:TEMPLATE_URL."images/post.jpg"; ?>);"></div>
	  <a class="user-name" href="<?=$NullTwoOption["info_website"]?$NullTwoOption["info_website"]:"javascript:;";?>"><!--<i class="iconfont icon Q-medal"></i>--><?=$NullTwoOption["info_nick"]?$NullTwoOption["info_nick"]:"二呆";?></a>
	  <img alt="" src="<?=$NullTwoOption["info_face"]?$NullTwoOption["info_face"]:"https://cambrian-images.cdn.bcebos.com/39ceafd81d6813a014e747db4aa6f0eb_1524963877208.jpeg";?>" class="user-avatar" height="60" width="60">
	  <!--
	  <i class="icon Q-certify-3" style="position: absolute;left: 58px;top: 94px;border-radius: 100%;color: var(--accent-color);background: #fff;font-size: 14px;"></i>
	  -->
	  <p class="user_des"><?=$NullTwoOption["info_desc"]?$NullTwoOption["info_desc"]:"岂能尽如人意，但求无愧我心。";?>​​​​​​</p>
	  <div class="user_info">
		<li class="ptnum"><?php echo count_log_all();?><span>文章</span></li>
		<li class="frinum"><?php echo count_com_all();?><span>评论</span></li>
		<li class="vitnum"><?php echo count_tw_all();?><span>微语</span></li>
	  </div>
	</div>
	<?php if($NullTwoOption["info_qq"]||$NullTwoOption["info_weixin"]||$NullTwoOption["info_website"]||$NullTwoOption["info_mail"]){?>
	<div class="style about-item">
	  <div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
	  <h3 class="section-title"><i class="iconfont icon Q-hacker"></i>联系</h3>
		<ul class="about_me">
		  <?php if($NullTwoOption["info_qq"]){?>
		  <li class="nowrap"><i class="iconfont icon Q-qq" style="color: #16c0e8;"></i><a href="tencent://message/?uin=<?=$NullTwoOption["info_qq"];?>" rel="nofollow"><?=$NullTwoOption["info_qq"];?></a></li>
		  <?php }?>
		  <?php if($NullTwoOption["info_weixin"]){?>
		  <li class="nowrap"><i class="iconfont icon Q-wechat" style="color: #24ef3f;"></i><?=$NullTwoOption["info_weixin"];?></li>
		  <?php }?>
		  <?php if($NullTwoOption["info_website"]){?>
		  <li class="nowrap"><i class="iconfont icon Q-home" style="color: #16c0e8;"></i><?=str_replace("http://","",str_replace("https://","",$NullTwoOption["info_website"]));?></li>
		  <?php }?>
		  <?php if($NullTwoOption["info_mail"]){?>
		  <li class="nowrap"><i class="iconfont icon Q-message" style="color: #f8c774;"></i><a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=<?=$NullTwoOption["info_mail"];?>" rel="nofollow" target="_blank"><?=$NullTwoOption["info_mail"];?></a></li>
		   <?php }?>
		</ul>
	</div>
	 <?php }?>
	<?php if($NullTwoOption["is_like"]=="y"){?>
	<div class="style like-item hint--top" aria-label="最喜欢你了(๑′ᴗ‵๑)">
	<div class="bg_xx"><div class="bg"></div></div>
		<div class="like-vote">
			<p class="like-title">Do you like me?</p>
			<div class="like-count">
				<i class="icon Q-heart throb"></i><span><?=$NullTwoOption["like_count"];?></span>
			</div>
		</div>
	</div>
	<?php }?>
	<?php
	$ad_left=explode("|",$NullTwoOption["ad_left"]);
	if(count($ad_left)==2){
	?>
	<div class="style img-item">
	  <div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
	  <a href="<?=$ad_left[0];?>" rel="nofollow" target="_blank"><img src="<?=$ad_left[1];?>" class="lazy"></a>
	</div>
	<?php
	}
	?>
	<?php
	if($NullTwoOption["is_visitor_ranking"]=="y"){
		blog_visitor_ranking_left(10);
	}
	?>
	<?php 
	$widgets = !empty($options_cache['widgets2']) ? unserialize($options_cache['widgets2']) : array();
	doAction('diff_side');
	foreach ($widgets as $val){
		$widget_title = @unserialize($options_cache['widget_title']);
		$custom_widget = @unserialize($options_cache['custom_widget']);
		if(strpos($val, 'custom_wg_') === 0)
		{
			$callback = 'widget_custom_text';
			if(function_exists($callback))
			{
				call_user_func($callback, htmlspecialchars($custom_widget[$val]['title']), $custom_widget[$val]['content']);
			}
		}else{
			$callback = 'widget_'.$val;
			if(function_exists($callback))
			{
				preg_match("/^.*\s\((.*)\)/", $widget_title[$val], $matchs);
				$wgTitle = isset($matchs[1]) ? $matchs[1] : $widget_title[$val];
				call_user_func($callback, htmlspecialchars($wgTitle));
			}
		}
	}
	?>
</aside>