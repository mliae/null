<?php 
/*
Custom:page_archivers
Description:归档
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<?php
function displayRecord(){
	global $CACHE; 
	$record_cache = $CACHE->readCache('record');
	$output = '';
	foreach($record_cache as $value){
		$output .= '<div class="archive-title"><h3>'.$value['record'].'('.$value['lognum'].'篇文章)</h3>'.displayRecordItem($value['date']).'';
	}
	$output = '<div id="archives-temp">'.$output.'</div>';
	return $output;
}
function displayRecordItem($record){
	if (preg_match("/^([\d]{4})([\d]{2})$/", $record, $match)) {
		$days = getMonthDayNum($match[2], $match[1]);
		$record_stime = Strtotime($record . '01');
		$record_etime = $record_stime + 3600 * 24 * $days;
	} else {
		$record_stime = Strtotime($record);
		$record_etime = $record_stime + 3600 * 24;
	}
	$sql = "and date>=$record_stime and date<$record_etime order by top desc ,date desc";
	$result = archiver_db($sql);
	return $result;
}
function archiver_db($condition = ''){
	$DB = Database::getInstance();
	$sql = "SELECT gid, title, date, views FROM " . DB_PREFIX . "blog WHERE type='blog' and hide='n' $condition";
	$result = $DB->query($sql);
	$output = '';
	while ($row = $DB->fetch_array($result)) {
		$log_url = Url::log($row['gid']);
		$output .= '<div class="brick"><span class="time">'.date('d日',$row['date']).'：</span><a href="'.$log_url.'">'.$row['title'].'</a><span class="pid">ID：'.$row['gid'].'</span></div>';
	}
	$output = empty($output) ? '<span class="ar-circle"></span><div class="arrow-left-ar"></div><div class="brick">暂无文章</div>' : $output;
	$output = '<div class="archives" id="monlist">'.$output.'</div></div>';
	return $output;
}
?>
			<section class="style books">
			<header class="entry-header">
				<h1 class="title" itemprop="name"><?php echo $log_title; ?></h1>
						<div class="meta">发布于 <time itemprop="datePublished" datetime="<?php echo date('c', $date);?>"><?php echo date('Y年m月d日', $date);?></time> / <?php blog_author($author); ?></div>
			</header>
			<?php echo displayRecord();?>
				<div class="single">
					<?php echo reply_view(unCompress(formatContent($log_content)),$logid); ?>
				</div>
			</section>
			<?php if($allow_remark == 'y'): ?>
			<div class="comment-container">
				<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
				<?php blog_comments($comments,$params); ?>
			</div>
			<?php endif;?>
			<?php include View::getView('footer');?>