<?php 
/**
 * 最热文章
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}

$Log_Model = new Log_Model();
$CACHE = Cache::getInstance();

$options_cache = Option::getAll();
extract($options_cache);

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$pageurl = '';
$sqlSegment ='ORDER BY views DESC, comnum DESC';
$sta_cache = $CACHE->readCache('sta');
$lognum = $sta_cache['lognum'];
$pageurl .= BLOG_URL."?post_type=hot&page=";
$total_pages = ceil($lognum / $index_lognum);
if ($page > $total_pages) {
	$page = $total_pages;
}
$logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
?>
<?php if (!empty($logs)){?>
	<div class="main-list preview">
	  <!-- main-list post -->
	  <?php foreach($logs as $value){?>
	  <article class="post style" data-id="<?php echo $value['logid']; ?>" data-url="<?php echo $value['log_url']; ?>">
	  <div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
		<?php if($value["top"]=="y"||$value["sortop"]=="y"){?>
		<div class="vipcover" style=""></div>
		<span class="sticky"></span>
		<?php }?>
		<div class="f-head">
		 <div class="f-img">
			<img src="<?php blog_photo($value['author']); ?>">
			<i class="icon Q-certify-3"></i>
		 </div>
		 <div class="f-info" id="ajax_a">
			 <div class="f-title nowrap">
				 <a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a>
			 </div>
			 <div class="f-info-v">
				 <span class="name"><i class="icon Q-at"></i> <?php blog_author($value['author']); ?></span>
				 <span class="time"><?php echo smartDate($value['date']); ?></span>
				 <span><i class="icon Q-fire" style="color: #f55;"></i></span>
			 </div>
		 </div>
		</div>
		<?php
		$logdes = reply_view(unCompress(formatExcerpt($value['content'],200)),$value['logid']);
		$imgsrc = preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $value['content'], $img);$imgsrc = !empty($img[1]) ? $img[1][0] : '';
		?>
		<div class="f-content">
			<p><?php echo preg_replace("#\[smilies(\d+)\]#i",'',$logdes); ?></p>
			<?php
			$video=getVideoCode($value['content']);
			if(count($video)!=0){
				if(strpos($video[0][0],'iframe')){
					?>
					<iframe height="400" width="100%" src="<?=$video[2][0];?>" frameborder="0" "allowfullscreen"></iframe>
					<?php
				}else if(strpos($video[0][0],'video')&&strpos($video[2][0],'.mp4')){
					?>
					<video width="100%" src="<?=$video[2][0];?>" controls="controls"></video>
					<?php
				}else if($value['thumbs'] != ''||$imgsrc){
					?>
					<div id="gallery-1" class="gallery">
						<dl class="gallery-item">
							<dt>
								<?php if($value['thumbs'] != ''||$imgsrc){ ?>
								<a href="<?php if($value['thumbs'] != ''){ echo $value['thumbs']; }else{ if($imgsrc){ echo $imgsrc; }else{ echo $NullTwoOption["home_pic_url"]?$NullTwoOption["home_pic_url"]:TEMPLATE_URL."images/post.jpg"; }; }; ?>" no-pjax target="_blank">
									<img alt="" src="<?php echo TEMPLATE_URL; ?>images/load.gif" data-src="<?php if($value['thumbs'] != ''){ echo $value['thumbs']; }else{ if($imgsrc){ echo $imgsrc; }else{ echo $NullTwoOption["home_pic_url"]?$NullTwoOption["home_pic_url"]:TEMPLATE_URL."images/post.jpg"; }; }; ?>" class="lazy">
								</a>
								<?php } ?>
							</dt>
						</dl>				
					</div>
					<?php
				}
			}
			?>
			<?php if($value['views']>=2000){?>
			<span class="hot-board lv3">
				<span class="icon-hot-wrap">
					<span class="icon-hot"></span>
				</span>
				<span class="text-hot">热度 2000℃</span>
			</span>
			<?php }?>
		</div>
		<?php
		preg_match_all("/<img.*src=[\"'](.*)[\"']/Ui", $value['content'], $imgs);
		$imgNum = count($imgs[1]);
		?>
		<div class="f-bottom">
			<a href="javascript:;" data-action="slzan" data-gid="<?php echo $value['logid']; ?>" class="hint--right like " aria-label="点赞">
				<i class="icon Q-heart-l"></i>
				<span class="count"><?php echo $value['slzan']; ?></span>
			</a>
			<a><i class="icon Q-talk"></i><span><?php echo $value['comnum']; ?></span></a>
			<a><i class="icon Q-eye"></i><span><?php echo $value['views'];?></span></a>
			<a><i class="icon Q-image"></i><span><?php echo $imgNum;?></span></a>
		</div>
	  </article>
	  <?php }?>
	  <!-- main-list post -->
	</div>
	<div class="navigator style">
		<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
		<?php echo getPageUrl($lognum, $index_lognum, $page, $pageurl);?>
	</div>
<?php }else{?>
	<div class="main-list preview">
		<article class="post style">
			<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
			<div class="no_result" style="text-align: center;">
				<p class="no_res_text" style="font-size: 30px;">这里什么都没有了</p>
			</div>
		</article>
	</div>
	<div class="navigator style">
		<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
	</div>
<?php }?>