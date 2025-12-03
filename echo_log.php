<?php 
/**
 * 阅读文章页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
			<section class="style books">
				<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
				<header class="entry-header">
					<h1 class="title" itemprop="name"><?php echo $log_title; ?></h1>
					<div class="meta">发布于 <time itemprop="datePublished" datetime="<?php echo date('c', $date);?>"><?php echo smartDate($date);?></time> / <?php echo $views; ?> 次围观 / <?php echo $comnum; ?> 条评论 / <?php blog_sort($logid); ?> / <?php blog_author($author); ?> / <?php if(ROLE==ROLE_ADMIN){editflg($logid,$author);}?></div>
				</header>
				<div class="single">
					<?php echo reply_view(unCompress(formatContent($log_content)),$logid); ?>
					<?php doAction('log_related', $logData); ?>
					<?php doAction('echo_log', $logData); ?>
					<?php blog_tag($logid) ?>
				</div>
				<?php
				$singleRow = $db->once_fetch_array("SELECT slzan FROM " . DB_PREFIX . "blog WHERE gid = ".$logid);
				?>
				<div class="f-bottom">
					<a href="javascript:;" data-action="slzan" data-gid="<?php echo $logid; ?>" class="hint--right like " aria-label="点赞">
						<i class="icon Q-heart-l"></i>
						<span class="count"><?php echo $singleRow["slzan"];?></span>
					</a>
					<a href="javascript:;" class="reward-click hint--top"  aria-label="给博主一点支持"><i class="icon  Q-gift"></i><span>打赏</span></a>
					<a href="javascript:;" data-url="http://service.weibo.com/share/share.php?url=<?php echo curPageURL(); ?>&title=<?php echo $log_title; ?>&source=<?php echo $blogname; ?>&sourceUrl=<?php echo BLOG_URL; ?>&content=utf8&searchPic=false"
					data-src="<?php echo $NullTwoOption["home_pic_url"]?$NullTwoOption["home_pic_url"]:TEMPLATE_URL."images/post.jpg"; ?>"
					class="poster-share-click hint--left"
					aria-label="分享至微博"><i class="icon Q-share-o"></i><span>分享</span></a>
				</div>
				<div class="reward">
					<ul>
						<li class="alipay"><img src="<?=$NullTwoOption["alipay_qrcode"]?$NullTwoOption["alipay_qrcode"]:"https://www.tongleer.com/api/web/alipay.jpg";?>"></li>
						<li><img src="<?=$NullTwoOption["wxpay_qrcode"]?$NullTwoOption["wxpay_qrcode"]:"https://me.tongleer.com/content/uploadfile/201706/008b1497454448.png";?>"></li>
						<li class="qq"><img src="<?=$NullTwoOption["qqpay_qrcode"]?$NullTwoOption["qqpay_qrcode"]:"https://www.tongleer.com/api/web/qqpaytwo.png";?>"></li>
					</ul>
				</div>
			</section>
			<?php if($allow_remark == 'y'): ?>
			<div class="comment-container">
				<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
				<?php blog_comments($comments,$params); ?>
			</div>
			<?php endif;?>
			<?php include View::getView('footer');?>