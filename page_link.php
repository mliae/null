<?php 
/*
Custom:page_link
Description:友链
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
				<ul class="bilibili-links" id="links">
					<?php
					if(Option::EMLOG_VERSION>="6.0.1"){
						$sortlinkSql = "SELECT * FROM ".DB_PREFIX."sortlink order by taxis";
						$sortlinkRet = $db->query($sortlinkSql);
						$sortlink = array();
						while ($sortlinkRow = $db->fetch_array($sortlinkRet)) {
							$sortlink[$sortlinkRow["linksort_id"]] = $sortlinkRow;
						}
						foreach($sortlink as $val){
							?>
							<h4><i class="iconfont icon Q-circle"></i> <?=$val["linksort_name"];?></h4>
							<?php
							$linkSql = "SELECT * FROM ".DB_PREFIX."link where hide='n' and linksortid=".$val["linksort_id"]." order by taxis";
							$linkRet = $db->query($linkSql);
							$link = array();
							while ($linkRow = $db->fetch_array($linkRet)) {
								$link[$linkRow["id"]] = $linkRow;
							}
							foreach($link as $value){
								?>
								<li class="list-item">
									<a class="cover" href="<?=$value["siteurl"];?>" target="_blank" rel="nofollow">
										<img src="<?=$value["sitepic"];?>" alt="<?=$value["sitename"];?>" class="lazy">
									</a>
									<div class="content">
										<span class="title"><?=$value["sitename"];?></span>
										<p class="desc"><?=$value["description"];?></p>
										<div class="fans-action">
											<a class="fans-action-btn" href="<?=$value["siteurl"];?>" target="_blank">
											<span class="fans-action-text">访问TA</span>
											</a>
										</div>
									</div>
								</li>
								<?php
							}
						}
					}else{
						?>
						<h4><i class="iconfont icon Q-circle"></i> 友情链接</h4>
						<?php
						$linkSql = "SELECT * FROM ".DB_PREFIX."link where hide='n' order by taxis";
						$linkRet = $db->query($linkSql);
						$link = array();
						while ($linkRow = $db->fetch_array($linkRet)) {
							$link[$linkRow["id"]] = $linkRow;
						}
						foreach($link as $value){
							?>
							<li class="list-item">
								<?php if(Option::EMLOG_VERSION>="6.0.1"){?>
								<a class="cover" href="<?=$value["siteurl"];?>" target="_blank" rel="nofollow">
									<img src="<?=$value["sitepic"];?>" alt="<?=$value["sitename"];?>" class="lazy">
								</a>
								<div class="content">
								<?php }?>
									<span class="title"><?=$value["sitename"];?></span>
									<p class="desc"><?=$value["description"];?></p>
									<div class="fans-action">
										<a class="fans-action-btn" href="<?=$value["siteurl"];?>" target="_blank">
										<span class="fans-action-text">访问TA</span>
										</a>
									</div>
								<?php if(Option::EMLOG_VERSION>="6.0.1"){?>
								</div>
								<?php }?>
							</li>
							<?php
						}
					}
					
					?>
				</ul>
			</section>
			<?php if($allow_remark == 'y'): ?>
			<div class="comment-container">
				<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
				<?php blog_comments($comments,$params); ?>
			</div>
			<?php endif;?>
			<?php include View::getView('footer');?>