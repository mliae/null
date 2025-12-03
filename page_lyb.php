<?php 
/*
Custom:page_lyb
Description:留言板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
$db = Database::getInstance();
?>
			<section class="style books">
				<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
				<header class="entry-header">
					<h1 class="title" itemprop="name"><?php echo $log_title; ?></h1>
					<div class="meta">发布于 <time itemprop="datePublished" datetime="<?php echo date('c', $date);?>"><?php echo date('Y年m月d日', $date);?></time> / <?php echo $comnum; ?> 条评论 / <?php blog_author($author); ?></div>
				</header>
				<div class="single">
					<?php echo reply_view(unCompress(formatContent($log_content)),$logid); ?>
					<?php doAction('log_related', $logData); ?>
					<?php doAction('echo_log', $logData); ?>
				</div>
			</section>
			<?php
			if($NullTwoOption["is_visitor_ranking"]=="y"){
				 blog_visitor_ranking_page(20);
			}
			?>
			<?php if($allow_remark == 'y'): ?>
			<div class="comment-container">
				<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
				<?php blog_comments($comments,$params); ?>
			</div>
			<?php endif;?>
			<?php include View::getView('footer');?>