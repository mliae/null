<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
		  </div>
		  <!-- main-central -->
		  <?php include View::getView('side_right'); ?>
		  <!-- main-right -->
		</div>
	  <!-- main -->
	  </div>
	</div>
	<!-- container -->
	<footer class="footer">
	  <div class="width">
		<div class="footer-content">
		  <?=$NullTwoOption["foot_custom_info"]?"<p>".$NullTwoOption["foot_custom_info"]."</p>":"";?>
		  <p>
			版权所有 © <?=date("Y");?> <a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a> | <a href="http://beian.miit.gov.cn" target="_blank" rel="nofollow"><?php echo $icp; ?></a>
			<br>Theme NullTwo By <a href="https://www.tongleer.com" target="_blank">二呆</a> FrontEnd by <a href="javascript:open('https://www.qiuzq.cn/');">瑾忆</a> | All Rights Reserved
			<br>由<a href="http://www.emlog.net" target="_blank">Emlog</a>强力驱动 | php <?=PHP_VERSION;?>
		  </p>
		  <p style="display:none;"><?php echo $footer_info; ?></p>
		</div>
	  </div>
	</footer>
	<!-- footer -->
</section>

<!-- #main -->
<a class="back2top"><i class="icon Q-rocket"></i></a>
<script src="<?php echo TEMPLATE_URL; ?>assets/js/baguettebox.js"></script>
<script type="text/javascript">var Null_data = {"TEMPLATE_URL":"<?php echo TEMPLATE_URL; ?>","BLOG_URL":"<?php echo BLOG_URL; ?>","Theme_Version":"<?php echo $Theme_Version;?>","EMLOG_VERSION":"<?=Option::EMLOG_VERSION;?>"};</script>
<script src="<?php echo TEMPLATE_URL; ?>assets/js/main.js"></script>
<script src="<?php echo TEMPLATE_URL; ?>assets/js/lazyload.min.js" type="text/javascript"></script>
<?php doAction('index_footer'); ?>
<?php if($NullTwoOption["player_switch"]=="y"){?>
<!-- require APlayer -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/aplayer/dist/APlayer.min.css">
<style>
.aplayer.aplayer-fixed.aplayer-narrow .aplayer-body {left: -66px;}
.aplayer .aplayer-miniswitcher .aplayer-icon{background-color: <?=isset($NullTwoOption["player_color"])?$NullTwoOption["player_color"]:"#009688";?>;}
.aplayer .aplayer-miniswitcher .aplayer-icon path {fill: #fff;}
.aplayer .aplayer-miniswitcher .aplayer-icon:hover path {fill: #fff;}
.aplayer .aplayer-info .aplayer-controller .aplayer-time .aplayer-icon:hover path {fill: <?=isset($NullTwoOption["player_color"])?$NullTwoOption["player_color"]:"#009688";?>;}
</style>
<script src="//cdn.jsdelivr.net/npm/aplayer/dist/APlayer.min.js"></script>
<!-- require MetingJS -->
<script src="//cdn.jsdelivr.net/npm/meting@2/dist/Meting.min.js"></script>
<meting-js
	server="netease"
	type="playlist"
	fixed="true"
	autoplay="<?=$NullTwoOption["player_is_auto"]=="y"?"true":"false";?>"
	order="random"
	theme="<?=isset($NullTwoOption["player_color"])?$NullTwoOption["player_color"]:"#009688";?>"
	id="<?=isset($NullTwoOption["player_list_id"])?$NullTwoOption["player_list_id"]:"503672348";?>">
</meting-js>
<script>
$(window).scroll(function(){
　　var scrollTop = $(this).scrollTop();
　　var scrollHeight = $(document).height();
　　var windowHeight = $(this).height();
　　if(scrollTop + windowHeight == scrollHeight){
		$(".aplayer-lrc").hide();
　　}else{
		$(".aplayer-lrc").show();
	}
});
</script>
<?php }?>
</body>
</html>
<?php $html=ob_get_contents();ob_get_clean();echo em_compress_html_main($html);?>