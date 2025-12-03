<?php 
/**
 * 右侧侧边栏
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<aside class="main-right main-mod">
	<?php if($NullTwoOption["user_login_switch"]=="y"){?>
	<div class="style user-item">
	  <div class="user_info">
		<li class=""><span><a href="<?=BLOG_URL;?>?user&publish">发布动态</a></span></li>
		<li class=""><span>&nbsp;</span></li>
		<li class="vitnum"><span><a href="<?=BLOG_URL;?>?user">会员中心</a></span></li>
	  </div>
	</div>
	<?php }?>
	<div class="style search-item">
		<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
		<form class="search-modal" method="get" action="<?php echo BLOG_URL; ?>" role="search">
			<i class="icon Q-search" style="position: absolute;bottom: 14px;left: 15px;"></i>
			<input class="text-input" type="search" name="keyword" placeholder="想要什么，就搜什么" autocomplete="off" style="padding: 0 0 0 25px;border: 0;width: 100%;line-height: 25px;font-size: 14px;background: transparent;">
		</form>
	</div>
	<?php if($NullTwoOption["notice"]){?>
	<div class="style gg-item">
	  <div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
	  <h3 class="section-title"><i class="iconfont icon Q-label-info"></i>公告</h3>
	  <div class="notice-content"><?=$NullTwoOption["notice"]?$NullTwoOption["notice"]:"";?></div>
	</div>
	<?php }?>
	<?php
	$ad_right=explode("|",$NullTwoOption["ad_right"]);
	if(count($ad_right)==2){
	?>
	<div class="style img-item">
	  <div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
	  <a href="<?=$ad_right[0];?>" rel="nofollow" target="_blank"><img src="<?=$ad_right[1];?>"></a>
	</div>
	<?php
	}
	?>
	<?php 
	$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
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