<?php 
/**
 * 预览文章
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

$row = $db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "blog WHERE gid = ".$id." AND hide='n' AND checked='y'");
if ($row) {
	$logData = array(
		'log_title' => htmlspecialchars($row['title']),
		'timestamp' => $row['date'],
		'date' => $row['date'],
		'logid' => intval($row['gid']),
		'sortid' => intval($row['sortid']),
		'thumbs'=> htmlspecialchars($row['thumbs']),
		'copy' => intval($row['copy']),
		'copyurl'=> htmlspecialchars($row['copyurl']),
		'type' => $row['type'],
		'author' => $row['author'],
		'log_content' => rmBreak($row['content']),
		'views' => intval($row['views']),
		'comnum' => intval($row['comnum']),
		'top' => $row['top'],
		'sortop' => $row['sortop'],
		'attnum' => intval($row['attnum']),
		'allow_remark' => Option::get('iscomment') == 'y' ? $row['allow_remark'] : 'n',
		'password' => $row['password'],
		'template' => $row['template'],
		'slzan' => $row['slzan'],
		);
	?>
	<section class="style books">
		<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
		<header class="entry-header">
			<h1 class="title" itemprop="name"><?php echo $logData["log_title"]; ?></h1>
			<div class="meta">发布于 <time itemprop="datePublished" datetime="<?php echo date('c', $logData["date"]);?>"><?php echo smartDate($logData["date"]);?></time> / <?php echo $logData["views"]; ?> 次围观 / <?php echo $logData["comnum"]; ?> 条评论 / <?php blog_sort($logData["logid"]); ?></ / <?php blog_author($logData["author"]); ?></div>
		</header>
		<div class="single">
			<?php echo reply_view(unCompress(formatContent($logData["log_content"])),$logData["logid"]); ?>
			<?php doAction('log_related', $logData); ?>
			<?php doAction('echo_log', $logData); ?>
			<?php blog_tag($logData["logid"]) ?>
		</div>
		<div class="f-bottom">
			<a href="javascript:;" data-action="slzan" data-gid="<?php echo $logData["logid"]; ?>" class="hint--right like " aria-label="点赞">
				<i class="icon Q-heart-l"></i>
				<span class="count"><?php echo $logData["slzan"];?></span>
			</a>
			<a href="javascript:;" class="reward-click hint--top"  aria-label="给博主一点支持"><i class="icon  Q-gift"></i><span>打赏</span></a>
			<a href="javascript:;" data-url="http://service.weibo.com/share/share.php?url=<?php echo curPageURL(); ?>&title=<?php echo $logData["log_title"]; ?>&source=<?php echo $blogname; ?>&sourceUrl=<?php echo BLOG_URL; ?>&content=utf8&searchPic=false"
			data-src="<?=$NullTwoOption["home_pic_url"]?$NullTwoOption["home_pic_url"]:TEMPLATE_URL."images/post.jpg";?>"
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
		<header class="entry-header">
			<center><a href="javascript:pjax.loadUrl('<?php echo Url::log($logData["logid"]);?>');overlay_disappear('jspost');">查看完整内容</a></center>
		</header>
	</section>
	<?php
}
?>