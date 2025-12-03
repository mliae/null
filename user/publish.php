<?php 
/**
 * 用户发布
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 

global $CACHE;
$user_cache = $CACHE->readCache('user');

$action = isset($_GET['action']) ? addslashes(trim($_GET['action'])) : '';
if($_POST){
	if(!UID){
		echo "<script>alert('请先登录！');location.href='".BLOG_URL."?user';</script>";
		exit;
	}
	$publish = isset($_POST['publish']) ? addslashes(trim($_POST['publish'])) : '';
	switch($publish){
		case "publish_article":
		case "edit_article":
			$blogid = isset($_POST['blogid']) ? intval(trim($_POST['blogid'])) : -1;
			$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
			$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
			$postTime=time();
			$logData = array(
				'title' => $title,
				'content' => $content,
				'author' => UID,
				'date' => $postTime,
				'checked' => $user_cache[UID]['ischeck'] == 'y' ? 'n' : 'y'
			);
			$Log_Model = new Log_Model();
			if ($blogid > 0) {
				$Log_Model->updateLog($logData, $blogid);
			}else{
				if (!$blogid = $Log_Model->isRepeatPost($title, $postTime)) {
					$blogid = $Log_Model->addlog($logData);
				}
			}
			$CACHE->updateCache();
			doAction('save_log', $blogid);
			break;
	}
	echo "<script>alert('发布成功".($user_cache[UID]['ischeck'] == 'y' ? '，等待审核！' : '')."');location.href='".BLOG_URL."?user';</script>";
}
?>
<div id="post-type" class="style">
	<ul>
		<li class="current"><a class="post-type-link" href="<?php echo BLOG_URL; ?>?user&publish">文章</a></li>
	</ul>
</div>
<style>
table td{background-color:#fff;}
table input{border:0px;width:100%;height:100%;}
</style>
<?php
if($action==""){
	$publish = isset($_GET['publish']) ? intval($_GET['publish']) : 0;
	$logRow = $db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "blog WHERE gid = ".$publish);
	?>
	<div class="main-list">
		<form action="" method="post">
			<article class="post style">
				<form action="" method="post">
					<div class="bbbb">
						<input name="title" type="text" value="<?=$logRow?$logRow["title"]:"";?>" size="30" maxlength="245" required="required" placeholder="标题">
					</div>
					<div id="contentEditor"></div>
					<div class="fload-right" style="display:none;">
						<textarea id="content" name="content" cols="45" rows="8" maxlength="666" required="required" placeholder=""><?=$logRow?$logRow["content"]:"";?></textarea>
					</div>
					<div class="bbbb">
						<input type="hidden" name="publish" value="<?=$logRow?"edit_article":"publish_article";?>" />
						<input type="hidden" name="blogid" value="<?=$logRow?$logRow["gid"]:-1;?>" />
						<button class="btn" type="submit">发布</button>
					</div>
				</form>
			</article>
		</form>
	</div>
	<script type="text/javascript">
		var E = window.wangEditor;
		var contentEditor = new E('#contentEditor');
		var content = $('#content');
		contentEditor.customConfig.menus = [
			'bold',
			'fontSize',
			'emoticon',
			'quote',
			'foreColor',
			'justify',
			'code',
			'image'
		];
		contentEditor.customConfig.onchange = function (html) {
			content.val(html);
		};
		contentEditor.create();
		contentEditor.txt.html('<?=$logRow?$logRow["content"]:"";?>');
		content.val(contentEditor.txt.html());
	</script>
	<?php
}
?>
<?php include View::getView('footer'); ?>