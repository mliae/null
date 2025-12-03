<?php 
/**
 * 消息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}

$options_cache = Option::getAll();
extract($options_cache);

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$pageurl = BLOG_URL."?message&page=";

$sql = "SELECT * FROM ".DB_PREFIX."comment where hide='n' ORDER BY date DESC";
$ret = $db->query($sql);
$comments = array();
while ($row = $db->fetch_array($ret)) {
	$row['poster'] = htmlspecialchars($row['poster']);
	$row['mail'] = htmlspecialchars($row['mail']);
	$row['url'] = htmlspecialchars($row['url']);
	$row['content'] = htmlClean($row['comment']);
	$row['date'] = smartDate($row['date']);
	$row['children'] = array();
	$row['useragent'] = htmlspecialchars($row['useragent']);
	if($spot == 0) $row['level'] = isset($comments[$row['pid']]) ? $comments[$row['pid']]['level'] + 1 : 0;
	$comments[$row['cid']] = $row;
}
if($page<1){
	$page=1;
}
$commentNum=count($comments);
$total_pages = ceil($commentNum / $index_lognum);
if ($page > $total_pages) {
	$page = $total_pages;
}
if ($page > PHP_INT_MAX) {
	$page = PHP_INT_MAX;
}
if($page<=1){
	$before_page=1;
	if($total_pages>1){
		$after_page=$page+1;
	}else{
		$after_page=1;
	}
}else{
	$before_page=$page-1;
	if($page<$total_pages){
		$after_page=$page+1;
	}else{
		$after_page=$total_pages;
	}
}
$commentArr = array_slice($comments, ($page-1)*$index_lognum, $index_lognum);
?>
<?php if (!empty($commentArr)){?>
	  <div class="main-list">
	  <!-- main-list post -->
	  <?php
	  foreach($commentArr as $value){
		$logRow = $db->once_fetch_array("SELECT title,username,nickname FROM ".DB_PREFIX."blog as b,".DB_PREFIX."user as u WHERE b.author=u.uid AND gid = ".$value['gid']);
		?>
		<article class="post style">
			<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
				<div class="f-head">
				 <div class="f-img">
					<img alt="<?=$value["poster"];?>" src="<?=eflyGravatar($value["mail"]);?>">
				 </div>
				 <div class="f-info">
						<div class="f-title nowrap">
							<a href="<?=$value["url"];?>" target="_blank" rel="nofollow" no-pjax><?=$value["poster"];?></a>
							<!--<em class="icon lv0 Q-LV0"></em>-->
						</div>
						<div class="f-info-v">
							<span class="time"><?=$value["date"];?></span>
						</div>
				 </div>
				</div>
				<div class="f-content" id="ajax_a">
					<p><?=$value["content"];?></p>
					<a class="fui-box wt" href="<?=Url::log($value["gid"]);?>">
						<div class="img-box">
							<i class="icon Q-talk"></i>
						</div>
						<div class="txt-box">
							<p class="info">
								<?=$logRow["nickname"]?$logRow["nickname"]:$logRow["username"];?>&nbsp;<span class=" state">：</span><?=$logRow["title"];?>
							</p>
							<!--<p style="margin: 10px 0 0;"></p>-->
						</div>
					</a>
				</div>
		</article>
		<?php
	  }
	  ?>
	  <!-- main-list post -->
	</div>
	<div class="navigator style">
		<?php echo getPageUrl($commentNum, $index_lognum, $page, $pageurl);?>
	</div>
<?php }else{?>
	<div class="main-list">
		<article class="post style">
			<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
			<div class="no_result" style="text-align: center;">
				<p class="no_res_text" style="font-size: 30px;">这里什么都没有了</p>
			</div>
		</article>
	</div>
	<div class="navigator style">
	</div>
<?php }?>