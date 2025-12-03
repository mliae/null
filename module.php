<?php 
/**
 * 侧边栏组件、页面模块
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
$db = Database::getInstance();
initNullTwoData();
$NullTwoOption=getNullTwoData();
?>
<?php
function initNullTwoData(){
	$db = Database::getInstance();
	$themeNullTwo = $db->query("SELECT * FROM " . DB_PREFIX . "options WHERE option_name = 'theme:NullTwo'");
	if($db->num_rows($themeNullTwo)==0){
		$NullTwoOption=serialize(array());
		$db->query("INSERT INTO `".DB_PREFIX."options` (`option_name`,`option_value`) VALUES ('theme:NullTwo','".$NullTwoOption."')");
	}
}
function getNullTwoData(){
	$db = Database::getInstance();
	$themeNullTwo = $db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "options WHERE option_name = 'theme:NullTwo'");
	$NullTwoOption=unserialize($themeNullTwo["option_value"]);
	return $NullTwoOption;
}
?>
<?php
//widget：blogger
function widget_blogger($title){
	$NullTwoOption=getNullTwoData();
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	?>
	<div class="style user-item">
	  <div class="user-bg" style="background-image: url(<?php echo $NullTwoOption["home_pic_url"]?$NullTwoOption["home_pic_url"]:TEMPLATE_URL."images/post.jpg";?>);"></div>
	  <a class="user-name" href="<?php echo BLOG_URL; ?>"><i class="iconfont czs-hacker"></i>&nbsp;<?php echo $user_cache[1]['name']; ?></a>
	  <img alt="" src="<?php if($user_cache[1]['photo']['src']){echo BLOG_URL.$user_cache[1]['photo']['src'];}else{echo TEMPLATE_URL.'images/avatar.jpg';}?>" class="user-avatar" height="60" width="60">
	  <p class="user_des"><?php if($user_cache[1]['des']){echo $user_cache[1]['des'];}else{echo $NullTwoOption["info_desc"]?$NullTwoOption["info_desc"]:"岂能尽如人意，但求无愧我心。";}?></p>
	  <div class="user_info">
		<li class="ptnum"><?php echo count_log_all();?><span>文章</span></li>
		<li class="frinum"><?php echo count_com_all();?><span>评论</span></li>
		<li class="vitnum"><?php echo count_tw_all();?><span>微语</span></li>
	  </div>
	</div>
<?php }?>
<?php
//widget：热门文章
function widget_hotlog($title){
	$db = Database::getInstance();
    $index_hotlognum = Option::get('index_hotlognum');
    $Log_Model = new Log_Model();
    $hotLogs = $Log_Model->getHotLog($index_hotlognum);
	?>
	<div class="style hot-comment">
	<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
	  <h3 class="section-title"><i class="iconfont icon Q-choose-list"></i><?php echo $title; ?></h3>
	  <ul class="items hot-comment">
		<?php
		foreach($hotLogs as $value):
			$logRow = $db->once_fetch_array("SELECT comnum FROM " . DB_PREFIX . "blog WHERE gid = ".$value['gid']);
			?>
			<li class="item">
				<div class="image"><img alt="" src="<?php echo TEMPLATE_URL; ?>images/load.gif" data-src="<?php echo getpostimagetop($value['gid']);?>" class="lazy"></div>
				<div class="info">
					<h4 class="title nowrap"><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></h4>
					<div class="meta"><?php echo $logRow['comnum'];?>条发言，<?php echo blog_content($value['gid'],'views');?>次围观</div>
				</div>
			</li>
			<?php
		endforeach;
		?>
	  </ul>
	</div> 
<?php }?>
<?php
//widget：链接
function widget_link($title){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
	shuffle($link_cache);$link_cache = array_slice($link_cache,0,100);
	?>
	<div class="style links-item">
	<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
	  <h3 class="section-title"><i class="iconfont icon Q-link"></i><?php echo $title; ?></h3>
	  <div class="links">
		<?php foreach($link_cache as $value): ?>
		<a class="hint--top  hint--small" href="<?php echo $value['url']; ?>" data-hint="<?php echo $value['des']; ?>" title="<?php echo $value['des']; ?>" target="_blank" rel="nofollow"><?php echo $value['link']; ?></a>
		<?php endforeach; ?>
	  </div>
	</div>
<!-- #link -->
<?php }?>
<?php
//blog：编辑
function editflg($logid,$author){
	$editflg = ROLE == ROLE_ADMIN || $author == UID ? '<a href="'.BLOG_URL.ADMIN_DIR.'/write_log.php?action=edit&gid='.$logid.'" target="_blank">编辑</a>' : '';
	echo $editflg;
}
?>
<?php
function blog_visitor_ranking_left($visitornum){
	$db = Database::getInstance();
	?>
	<div class="style -item">
	  <div class="bg_xx"><div class="bg"></div></div>
	  <h3 class="section-title"><i class="iconfont icon Q-people"></i>访客排行</h3>
	  <ul class="items attention">
		<?php
		$sql = "SELECT cid,count(poster) as posternum,poster,url,mail,ip FROM ".DB_PREFIX."comment where hide='n' group by poster order by posternum desc limit 0,".$visitornum;
		$ret = $db->query($sql);
		$comments = array();
		while ($row = $db->fetch_array($ret)) {
			$row['poster'] = htmlspecialchars($row['poster']);
			$row['mail'] = htmlspecialchars($row['mail']);
			$row['url'] = htmlspecialchars($row['url']);
			$comments[$row['cid']] = $row;
		}
		foreach($comments as $value){
		?>
		<li class="item hint--top" aria-label="<?=$value["poster"];?>">
			<a href="<?=$value["url"]?$value["url"]:"javascript:;";?>" rel="nofollow" target="_blank">
				<img class="lazy" src="<?php echo TEMPLATE_URL; ?>images/avatar.jpg" data-src="<?=eflyGravatar($value["mail"]);?>" alt="avatar">
			</a>
		</li>
		<?php
		}
		?>
	  </ul>
	</div>
	<?php
}
?>
<?php
function blog_visitor_ranking_page($visitornum){
	$db = Database::getInstance();
	?>
	<div id="readerswall"  class="style">
		<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
		<h3 class="section-title"><i class="iconfont icon Q-people"></i>&nbsp;&nbsp;访客排行</h3>
		<ul class="gavaimg">
			<?php
			$sql = "SELECT cid,count(poster) as posternum,poster,url,mail,ip FROM ".DB_PREFIX."comment where hide='n' group by poster order by posternum desc limit 0,".$visitornum;
			$ret = $db->query($sql);
			$comments = array();
			while ($row = $db->fetch_array($ret)) {
				$row['poster'] = htmlspecialchars($row['poster']);
				$row['mail'] = htmlspecialchars($row['mail']);
				$row['url'] = htmlspecialchars($row['url']);
				$row['posternum'] = htmlspecialchars($row['posternum']);
				$comments[$row['cid']] = $row;
			}
			foreach($comments as $value){
			?>
			<li title="<?=$value["poster"];?>(哔哔了<?=$value["posternum"];?>次)"><a href="<?=$value["url"]?$value["url"]:"javascript:;";?>" target="_blank" rel="nofollow"><img class="lazy" src="<?php echo TEMPLATE_URL; ?>images/avatar.jpg" data-src="<?=eflyGravatar($value["mail"]);?>"></a><div class="active-bg"><div class="active-degree" style="width:29px;"></div></div></li>
			<?php
			}
			?>
		</ul>
	</div>
	<?php
}
?>
<?php
//获取blog表的一条内容,$content填写表名
function blog_content($gid,$content){
    $db = Database::getInstance();
    $sql = 'SELECT * FROM ' . DB_PREFIX . "blog WHERE gid='".$gid."'";
    $sql = $db->query($sql);
    while ($row = $db->fetch_array($sql)) {
        $content = $row[$content];
	}
    return $content;
}
?>
<?php
//blog：导航
function blog_navi(){
    global $CACHE; 
    $navi_cache = $CACHE->readCache('navi');
	foreach($navi_cache as $value):
	if ($value['pid'] != 0) {
		continue;
	}
	if($value['url'] == ROLE_ADMIN && (ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER)):
	?>
	   <li><a href="<?php echo BLOG_URL.ADMIN_DIR; ?>/"><i class="iconfont icon Q-home"></i>管理</a></li>
	   <li><a href="<?php echo BLOG_URL.ADMIN_DIR; ?>/?action=logout"><i class="iconfont icon Q-lock"></i>退出</a></li>
	<?php 
		continue;
	endif;
	$newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
	$value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
	$current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'active' : 'common';
	?>
	<?php if (!empty($value['children']) || !empty($value['childnavi'])) :?>
	<li class="dropdown">
		<?php if (!empty($value['children'])):?>
		<a href="<?php echo $value['url']; ?>"<?php echo $newtab;?>><?php echo $value['naviname']; ?></a>
		<ul class="dropdown-menu">
			<?php foreach ($value['children'] as $row){
					echo '<li><a href="'.Url::sort($row['sid']).'">'.$row['sortname'].'</a></li>';
			}?>
		</ul>
		<?php endif;?>
		<?php if (!empty($value['childnavi'])) :?>
		<a href="<?php echo $value['url']; ?>" <?php echo $newtab;?>><?php echo $value['naviname']; ?></a>
		<ul class="dropdown-menu">
			<?php foreach ($value['childnavi'] as $row){
					$newtab = $row['newtab'] == 'y' ? 'target="_blank"' : '';
					echo '<li><a href="' . $row['url'] . "\" $newtab >" . $row['naviname'].'</a></li>';
			}?>
		</ul>
		<?php endif;?>
	</li>
	<?php else: ?>
	<li>
	<a href="<?php echo $value['url']; ?>" <?php echo $newtab;?> />
	<?php if($value['naviname']=="首页"){  ?><i class="iconfont icon Q-home"></i> 
	 <?php }elseif($value['naviname']=="微语"){  ?><i class="iconfont icon Q-cup-l"></i>
	 <?php }elseif($value['naviname']=="留言"){  ?><i class="iconfont icon Q-talk"></i>  
	 <?php }elseif($value['naviname']=="关于"){  ?><i class="iconfont icon Q-doc-file"></i> 
	 <?php }elseif($value['naviname']=="归档"){  ?><i class="iconfont icon Q-read"></i>  
	 <?php }elseif($value['naviname']=="相册" || $value['naviname']=="微图册" ){  ?><i class="iconfont icon Q-image"></i> 
	 <?php }elseif($value['naviname']=="友链"){  ?><i class="iconfont icon Q-link"></i>   
	 <?php }elseif($value['naviname']=="登录"){  ?><i class="iconfont icon Q-lock"></i>
	 <?php }else{  ?><i class="iconfont icon Q-doc-file"></i> 
	<?php } ?>
	 <?php echo $value['naviname']; ?>
	 </a>
	</li>
<?php endif;?>
<?php endforeach; ?>
<?php }?>
<?php
//blog：分类
function blog_sort($blogid){
	global $CACHE; 
	$log_cache_sort = $CACHE->readCache('logsort');
	?>
	<?php if(!empty($log_cache_sort[$blogid])){?>
	<span class="h-categories"><a href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>" rel="category tag"><?php echo $log_cache_sort[$blogid]['name']; ?></a></span>
	<?php }else{?>
	<span class="h-categories">未分类</span>
	<?php }?>
<?php }?>
<?php
//blog：文章标签
function blog_tag($blogid){
	global $CACHE;
	$log_cache_tags = $CACHE->readCache('logtags');
	if (!empty($log_cache_tags[$blogid])){
		$tag = '';
		foreach ($log_cache_tags[$blogid] as $value){
			$tag .= "#<a href=\"".Url::tag($value['tagurl'])."\">".$value['tagname'].'</a>';
		}
		echo '<div class="hr-short"></div><div class="post-tags">'.$tag.'</div>';
	}
}
?>
<?php
//blog：文章作者
function blog_author($uid){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$author = $user_cache[$uid]['name'];
	$mail = $user_cache[$uid]['mail'];
	$des = $user_cache[$uid]['des'];
	$title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
	echo '<a href="'.Url::author($uid)."\" $title>$author</a>";
}
?>
<?php
//blog：文章作者头像
function blog_photo($uid){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	if($user_cache[$uid]['avatar']){
		$photo = BLOG_URL.$user_cache[$uid]['avatar'];
	}else{
		$photo = TEMPLATE_URL."images/avatar.jpg";
	}
	echo $photo;
}
?>
<?php
//blog-tool:判断是否是首页
function blog_tool_ishome(){
    if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL){
        return true;
    } else {
        return FALSE;
    }
}
?>
<?php
//blog：评论列表
function blog_comments($comments,$params){
    extract($comments);
    if($commentStacks){
		
	}
	?>
	<ol class="comment-lists">
	<?php
	$isGravatar = Option::get('isgravatar');
	$comnum = count($comments);  
	foreach($comments as $value){  
	if($value['pid'] != 0){$comnum--;}}  
	$page = isset($params[5])?intval($params[5]):1;  
	$i= $comnum - ($page - 1)*Option::get('comment_pnum'); 
	foreach($commentStacks as $cid){
		$comment = $comments[$cid];
		$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
		?>
		<li class="comment-list style" id="comment-<?php echo $comment['cid']; ?>">
		  <div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
			<div class="comment-body">
			  <div class="b-info-v">
				<span class="time"><?php echo $comment['date']; ?></span>					 
			  </div>
	         <div class="b-img">
			    <img src="<?php echo eflyGravatar($comment['mail']); ?>" alt="">	
				<a rel="nofollow" class="comment-reply" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>)">@</a>
	         </div>
		     <div class="b-info">
				<div class="b-title nowrap">
					<a href="<?php echo $comment['url']; ?>" target="_blank" rel="nofollow"><?php echo $comment['poster']; ?></a><!--<em class="icon lv0 Q-LV0"></em>-->
				</div>
				<div class="comment-content">
					<p><?php echo preg_replace("#\[smilies(\d+)\]#i",'<img src="'.TEMPLATE_URL.'images/face/$1.png" id="smilies$1" alt="表情$1"/>',$comment['content']); ?></p>
				</div>
		     </div>
			</div>
			<div class="review_form" id="content-<?php echo $comment['cid']; ?>">
			</div>
		    <ul id="comment-ul-<?php echo $comment['cid']; ?>">
				<?php blog_comments_children($comments, $comment['children'],$i,0); ?>
			</ul>
		</li>
		<?php
		$i--;
	}
	?>
    <div id="pagenavi">
	    <?php echo $commentPageUrl;?>
    </div>
	</ol>
<?php
}
?>
<?php
//blog：子评论列表
function blog_comments_children($comments, $children,$i,$x){
	$isGravatar = Option::get('isgravatar');
	foreach($children as $child){
	$comment = $comments[$child];
	$x=$x+1; 
	$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
	$bicomment = preg_replace("#\@瑾忆:#",'<span class="vip" style="background-color: #FFC107;">@博主:</span>',$comment['content']);
	?>
	<li class="comment-list style" id="comment-<?php echo $comment['cid']; ?>">
		<div class="comment-body">
		  <div class="b-info-v">
			<span class="time"><?php echo $comment['date']; ?></span>					 
		  </div>
		 <div class="b-img">
			<img src="<?php echo eflyGravatar($comment['mail']); ?>" alt="">	
			<a rel="nofollow" class="comment-reply" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>)">@</a>
		 </div>
		 <div class="b-info">
			<div class="b-title nowrap">
				<a href="<?php echo $comment['url']; ?>" target="_blank" rel="nofollow"><?php echo $comment['poster']; ?></a><!--<em class="icon lv0 Q-LV0"></em>-->
			</div>
			<div class="comment-content">
				<p><?php echo preg_replace("#\[smilies(\d+)\]#i",'<img src="'.TEMPLATE_URL.'images/face/$1.png" id="smilies$1" alt="表情$1"/>',$comment['content']); ?></p>
			</div>
		 </div>
		</div>
		<div class="review_form" id="content-<?php echo $comment['cid']; ?>">
		</div>
		<ul id="comment-ul-<?php echo $comment['cid']; ?>">
			<?php blog_comments_children($comments, $comment['children'],$i); ?>
		</ul>
	</li>
	<?php 
	}
}
?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	if($allow_remark == 'y'){
	?>
	<div id="comment-place" class="style">
		<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
		<div id="comment-post" class="comment-respond">
			<form action="<?php echo BLOG_URL; ?>index.php?action=addcom" method="post" id="commentform" class="comment-form">
				<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
				<div class="comment-main">
					<?php if(ROLE == ROLE_VISITOR){?>
					<div class="bbbb">
						<input id="author" name="comname" type="text" value="<?php echo $ckname; ?>" size="30" maxlength="245" aria-required="true" required="required" placeholder="昵称 (必填)">
						<input id="email" name="commail" type="email" value="<?php echo $ckmail; ?>" size="30" maxlength="100" aria-describedby="email-notes" aria-required="true" required="required" placeholder="邮件地址 (必填)">
						<input id="url" name="comurl" type="url" value="<?php echo $ckurl; ?>" size="30" maxlength="200" placeholder="个人主页 (选填)">
					</div>
					<?php }?>
					<div class="bbq">
						<div class="fload-left">
							<img src="<?php if(ROLE == ROLE_VISITOR){ echo TEMPLATE_URL.'images/avatar.jpg'; }else{ echo $user_cache[UID]["photo"]["src"]?$user_cache[UID]["photo"]["src"]:eflyGravatar($user_cache[UID]["mail"]); }; ?>" class="ajaxurl">
						</div>
						<div class="fload-right">
							<textarea id="comment" name="comment" cols="45" rows="8" maxlength="666" aria-required="true" required="required" placeholder="既然来了就说点什么吧..."></textarea>
						</div>
					</div>
					<div class="bbbb">
						<?php if((defined("SEND_MAIL")&&SEND_MAIL == 'Y') || (defined("SEND_MAIL")&&REPLY_MAIL == 'Y')){ ?>
						<label class="demo--label">
							<input class="demo--radio" value="y" type="checkbox" name="send" checked>
							<span class="demo--checkbox demo--radioInput"></span>允许邮件通知
						</label>
						<?php } ?>
						<span class="OwO">
							<div class="OwO-logo">
								<span>表情</span>
							</div>
							<div class="OwO-body">
								<ul class="OwO-items OwO-items-biaoqing OwO-items-show" style="max-height: 200px;">
									<!--
									<?php for($i = 1; $i <= 39; $i++): ?>
									<a class="OwO-item" data-action="addSmily" data-smilies="smilies<?php echo $i; ?>"><img src="<?php echo TEMPLATE_URL; ?>images/face/<?php echo $i; ?>.png"></a>
									<?php endfor; ?>
									-->
								</ul>
							</div>
						</span>
						<?php echo $verifyCode; ?>
					</div>
					<div class="wantcom" style="text-align: center;"></div>
					<div class="bbbb">
						<a rel="nofollow" class="btn" id="cancel-reply" href="javascript:void(0);" onclick="cancelReply()" style="display:none;"> 取消回复</a>
						<button class="btn" name="submit" type="submit" id="submit">提交评论</button>
						<input type="hidden" name="pid" id="comment-pid" value="0"/>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php
	}
}
?>
<?php
//统计文章总数
function count_log_all($uid=""){
	$db = Database::getInstance();
	$uid=$uid?" and author=".$uid:"";
	$data = $db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE type = 'blog' and hide='n' and checked='y'".$uid);
	return $data['total']?$data['total']:0;
}
//统计评论总数
function count_com_all($uid=""){
	$db = Database::getInstance();
	$uid=$uid?" and author=".$uid:"";
	$data = $db->once_fetch_array("SELECT sum(comnum) as total FROM " . DB_PREFIX . "blog where type = 'blog' and hide='n' and checked='y'".$uid);
	return $data['total']?$data['total']:0;
}
//统计微语总数
function count_tw_all(){
	if(Option::EMLOG_VERSION>="6.0.0"&&Option::EMLOG_VERSION<"6.0.1"){
		return 0;
	}
	$db = Database::getInstance();
	$data = $db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "twitter");
	return $data['total']?$data['total']:0;
}
?>
<?php
/**
 * 分页函数
 * @param int $count 条目总数
 * @param int $perlogs 每页显示条数目
 * @param int $page 当前页码
 * @param string $url 页码的地址
 */
function getPageUrl($count, $perlogs, $page, $url) {
	$re = '';
	$total_pages = ceil($count / $perlogs);
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
	$href=$page<$total_pages?$url.$after_page:"";
	$re="<a href=\"{$href}\" rel=\"nofollow\" id=\"ajax\" no-pjax>LOADING MORE</a>";
	return $re;
}
?>
<?php
//获取文章首张图片 内容用
function getpostimagetop($gid){
	$db = Database::getInstance();
	$NullTwoOption=getNullTwoData();
	$sql = "SELECT * FROM ".DB_PREFIX."blog WHERE gid=".$gid."";
	//die($sql);
	$imgs = $db->query($sql);
	$img_path = "";
	while($row = $db->fetch_array($imgs)){
		preg_match('|<img.*src=[\"](.*?)[\"]|', $row['content'], $img);
		$rand_img = $NullTwoOption["home_pic_url"]?$NullTwoOption["home_pic_url"]:TEMPLATE_URL."images/post.jpg";
		$imgsrc = !empty($img[0]) ? $img[1] : $rand_img;
    }
    return $imgsrc;
}
//获取文章附件图
function getPostAttImg($gid,$content) {
	$db = Database::getInstance();
	$atts = array();
	$sql = "SELECT * FROM ".DB_PREFIX."attachment where blogid=".$gid." and filesize>0 and filepath!='' and thumfor=0 and mimetype regexp 'image/*' order by addtime desc";
	$ret = $db->query($sql);
	$attachment = array();
	while ($row = $db->fetch_array($ret)) {
		$row['blogid'] = htmlspecialchars($row['blogid']);
		$row['filepath'] = htmlspecialchars($row['filepath']);
		$attachment[$row['aid']] = $row;
	}
	$key=1;foreach($attachment as $value){
		$atts[] = array('key' => "attach".$key, 'gid'=>$gid,'url' => BLOG_URL."content/".$value["filepath"]);
		$key++;
	}
	return $atts;
}

//获取文章内容图
function getPostHtmImg($gid,$content,$isShowDefault=true) {
	$db = Database::getInstance();
	$blogRow = $db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "blog WHERE gid = ".$gid);
	preg_match_all( "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $content, $matches);
	$atts = array();
	if(isset($matches[1][0])) {
		for($i = 0; $i < count($matches[1]); $i++) {
			$atts[] = array('key' => "blog".($i + 1),'gid'=>$gid,'title'=>$blogRow["title"], 'url' => $matches[1][$i]);
		}
    }else if($isShowDefault){
		$atts[] = array('key' => "0",'gid'=>$gid,'title'=>$blogRow["title"], 'url' => TEMPLATE_URL."images/post.jpg");
	}
	return  count($atts) ? $atts : array();
}

//获取文章图片 整合 getPostAttImg() 与 getPostHtmImg()
function getPostImg($gid,$content,$isShowDefault=true) {
	$NullTwoOption=getNullTwoData();
	$imgs = array();
	if($NullTwoOption["album_source"] == "") {
		$imgs = getPostHtmImg($gid,$content,$isShowDefault);
	}elseif($NullTwoOption["album_source"] == "attach") {
		$imgs = getPostAttImg($gid,$content);
	}elseif($NullTwoOption["album_source"] == "all") {
		$imgs = array_merge(getPostHtmImg($gid,$content,$isShowDefault), getPostAttImg($gid,$content));
	}
	return $imgs;
}
?>
<?php
//点赞
function syzan(){
	$DB = Database::getInstance();
	if($DB->num_rows($DB->query("show columns from ".DB_PREFIX."blog like 'slzan'")) == 0){
		$sql = "ALTER TABLE ".DB_PREFIX."blog ADD slzan int unsigned NOT NULL DEFAULT '0'";
		$DB->query($sql);
	}
}
syzan();
function update($logid){
	$slzanId = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$logid = intval($slzanId);
	$DB = Database::getInstance();
	$DB->query("UPDATE " . DB_PREFIX . "blog SET slzan=slzan+1 WHERE gid=$logid");
	setcookie('slzanpd_'. $logid, 'true', time() + 31536000);
}
function lemoninit() {
	$action = isset($_POST['action']) ? addslashes(trim($_POST['action'])) : '';
	if($action == 'slzan'){
		$slzanPlugin = isset($_POST['plugin']) ? addslashes(trim($_POST['plugin'])) : '';
		$slzanId = isset($_POST['id']) ? intval($_POST['id']) : 0;
		if($slzanPlugin == 'slzanpd'&&$slzanId){
			$slzanId = intval($slzanId);
			header("Access-Control-Allow-Origin: *");
			update($slzanId);echo getnum($slzanId);die;
		}
	}
}
lemoninit();
function getnum($id){
	static $arr = array();
	$DB = Database::getInstance();
	if(isset($arr[$logid])) return $arr[$logid];
	$sql = "SELECT slzan FROM " . DB_PREFIX . "blog WHERE gid=$id";
	$res = $DB->query($sql);
	$row = $DB->fetch_array($res);
	$arr[$id] = intval($row['slzan']);
	return $arr[$id];
}
?>
<?php
//调用文章页url
function curPageURL(){
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on"){
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80"){
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }else{
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
?>
<?php
//blog-tool:获取qq头像
function eflyGravatar($email) {
	$hash = md5(strtolower($email));
	$avatar = 'https://secure.gravatar.com/avatar/' . $hash . '?s=100&d=monsterid';
	if(empty($email)){
		$eflyGravatar = TEMPLATE_URL.'images/avatar.jpg';
	}
	else if(strpos($email,'@qq.com')){
		$qq = str_replace("@qq.com","",$email);
		if(is_numeric($qq) && strlen($qq) > 4 && strlen($qq) < 13){
			$eflyGravatar = 'https://q2.qlogo.cn/headimg_dl?dst_uin='.$qq.'&spec=100';
		}
		else{
			$eflyGravatar = $avatar;
		}
	}
	else{
		$eflyGravatar = $avatar;
	}
	return $eflyGravatar;
}
?>
<?php
/*
 * 文章回复可见
 *
 */
 function reply_view($content,$logid){
	 if(!strstr($content,"hide")){
		 return $content;
	 }
	 if(ROLE == ROLE_ADMIN){
		 $content = preg_replace("/\[hide\](.*)\[\/hide\]/Uims", '<div style="color:#a66;border:1px solid #a66;">\1</div>', $content);
		 return $content;
	 }
   if(ROLE != ROLE_VISITOR){
	   //是会员的时候回复可见
	   global $userData;
	   $user_mail = $userData['email'];
	   //$logid = $logData['logid'];
	   $DB = Database::getInstance();
	   $sql = 	"SELECT * FROM ".DB_PREFIX."comment WHERE gid='$logid' and mail='$user_mail'";
	   $res = $DB->query($sql);
	   $num = $DB->num_rows($res);
	   if($num>0){
		   //已经回复过了
		   $share_view = preg_replace("/\[hide\](.*)\[\/hide\]/Uims", '<div style="color:#a66;border:1px solid #a66;">\1</div>', $content);
	   }else{
		   //未回复
		   $share_view = preg_replace("/\[hide\](.*)\[\/hide\]/Uims", '<div style="color:#a66;border:1px solid #a66;">此处内容已隐藏，注册会员<a href="'.Url::log($logid).'#comment-post">评论</a>即可查看</div>', $content);
	   }
	   
	   return $share_view;
   }else{
	   //是游客的时候回复可见
	   $share_view = preg_replace("/\[hide\](.*)\[\/hide\]/Uims", '<div style="color:#a66;border:1px solid #a66;">此处内容已隐藏，注册会员<a href="'.Url::log($logid).'#comment-post">评论</a>即可查看</div>', $content);
	   return $share_view;
   }
 }
?>
<?php
//格式化摘要
function formatExcerpt($content, $strlen = null){
	$content = preg_replace('/\[iframe\](.*)\[\/iframe\]/Uims', '', $content);
	$content = preg_replace('/\[video\](.*)\[\/video\]/Uims', '', $content);
	$content = str_replace('继续阅读&gt;&gt;', '', strip_tags($content));
	if ($strlen) {
		if(Option::get("isexcerpt")=="y"){
			$strlen=Option::get("excerpt_subnum");
		}
		$content = subString($content, 0, $strlen);
	}
	return $content;
}
//格式化内容
function formatContent($content){
	$matche_content=getVideoCode($content);
	for($i=0;$i<count($matche_content[0]);$i++){
		if(strpos($matche_content[0][$i],'iframe')){
			$content = str_replace($matche_content[0][$i], '<iframe height="400" width="100%" src="'.$matche_content[2][$i].'" frameborder="0" "allowfullscreen"></iframe>', $content);
		}else if(strpos($matche_content[0][$i],'video')&&strpos($matche_content[2][$i],'.mp4')){
			$content = str_replace($matche_content[0][$i], '<video width="100%" src="'.$matche_content[2][$i].'" controls="controls"></video>', $content);
		}else if(strpos($matche_content[0][$i],'video')){
			$content = str_replace($matche_content[0][$i], '', $content);
		}
	}
	return $content;
}
/*获取文章中视频代码*/
function getVideoCode($content){
    if(!preg_match_all( "/\[(video|VIDEO|iframe|IFRAME)\](.*)\[\/(video|VIDEO|iframe|IFRAME)\]/Uims", $content, $matches )){
		preg_match_all( "/<(iframe|IFRAME).*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $content, $matches );
	}
    return $matches;
}
/*压缩html代码*/
function em_compress_html_main($buffer){
    $initial=strlen($buffer);
    $buffer=explode("<!--em-compress-html-->", $buffer);
    $count=count ($buffer);
    for ($i = 0; $i <= $count; $i++){
        if (stristr($buffer[$i], '<!--em-compress-html no compression-->')){
            $buffer[$i]=(str_replace("<!--em-compress-html no compression-->", " ", $buffer[$i]));
        }else{
            $buffer[$i]=(str_replace("\t", " ", $buffer[$i]));
            $buffer[$i]=(str_replace("\n\n", "\n", $buffer[$i]));
            $buffer[$i]=(str_replace("\n", "", $buffer[$i]));
            $buffer[$i]=(str_replace("\r", "", $buffer[$i]));
            while (stristr($buffer[$i], '  '))
            {
            $buffer[$i]=(str_replace("  ", " ", $buffer[$i]));
            }
        }
        $buffer_out.=$buffer[$i];
    }
    $final=strlen($buffer_out);
    $savings=($initial-$final)/$initial*100;
    $savings=round($savings, 2);
    $buffer_out.="\n<!--压缩前的大小: $initial bytes; 压缩后的大小: $final bytes; 节约：$savings% -->";
    return $buffer_out;
}
function unCompress($content){
    if(preg_match_all('/(crayon-|<\/pre>)/i', $content, $matches)) {
        $content = '<!--em-compress-html--><!--em-compress-html no compression-->'.$content;
        $content.= '<!--em-compress-html no compression--><!--em-compress-html-->';
    }
    return $content;
}
/**
 * 文件上传
 *
 * 返回的数组索引
 * mime_type 文件类型
 * size      文件大小(单位KB)
 * file_path 文件路径
 * width     宽度
 * height    高度
 * 可选值（仅在上传文件是图片且系统开启缩略图时起作用）
 * thum_file   缩略图的路径
 * thum_width  缩略图宽度
 * thum_height 缩略图高度
 * thum_size   缩略图大小(单位KB)
 *
 * @param string $fileName 文件名
 * @param string $errorNum 错误码：$_FILES['error']
 * @param string $tmpFile 上传后的临时文件
 * @param string $fileSize 文件大小 KB
 * @param array $type 允许上传的文件类型
 * @param boolean $isIcon 是否为上传头像
 * @param boolean $is_thumbnail 是否生成缩略图
 * @return array 文件数据 索引 
 * 
 */
function uploadImages($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon = false, $is_thumbnail = true) {
	if ($errorNum == 1) {
		return '文件大小超过系统' . ini_get('upload_max_filesize') . '限制';
	} elseif ($errorNum > 1) {
		return '上传文件失败,错误码：' . $errorNum;
	}
	$extension = getFileSuffix($fileName);
	if (!in_array($extension, $type)) {
		return '错误的文件类型';
	}
	if ($fileSize > Option::getAttMaxSize()) {
		$ret = changeFileSize(Option::getAttMaxSize());
		return "文件大小超出{$ret}的限制";
	}
	$file_info = array();
	$file_info['file_name'] = $fileName;
	$file_info['mime_type'] = get_mimetype($extension);
	$file_info['size'] = $fileSize;
	$file_info['width'] = 0;
	$file_info['height'] = 0;
	$uppath = Option::UPLOADFILE_PATH . date('Ym') . '/';
	$fname = substr(md5($fileName), 0, 4) . time() . '.' . $extension;
	$attachpath = $uppath . $fname;
	$file_info['file_path'] = $attachpath;
	if (!is_dir(EMLOG_ROOT."/content/".Option::UPLOADFILE_PATH)) {
		@umask(0);
		$ret = @mkdir(EMLOG_ROOT."/content/".Option::UPLOADFILE_PATH, 0777);
		if ($ret === false) {
			return '创建文件上传目录失败';
		}
	}
	if (!is_dir(EMLOG_ROOT."/content/".$uppath)) {
		@umask(0);
		$ret = @mkdir(EMLOG_ROOT."/content/".$uppath, 0777);
		if ($ret === false) {
			return '上传失败。文件上传目录(content/uploadfile)不可写'; 
		}
	}
	doAction('attach_upload', $tmpFile);

	// 生成缩略图
	$thum = $uppath . 'thum-' . $fname;
	if ($is_thumbnail) {
		if ($isIcon && resizeImage($tmpFile, EMLOG_ROOT."/content/".$thum, Option::ICON_MAX_W, Option::ICON_MAX_H)) {
			$file_info['thum_file'] = $thum;
			$file_info['thum_size'] = filesize(EMLOG_ROOT."/content/".$thum);
			$size = getimagesize(EMLOG_ROOT."/content/".$thum);
			if ($size) {
				$file_info['thum_width'] = $size[0];
				$file_info['thum_height'] = $size[1];
			}
			resizeImage($tmpFile, EMLOG_ROOT."/content/".$uppath . 'thum52-' . $fname, 52, 52);
		} elseif (resizeImage($tmpFile, EMLOG_ROOT."/content/".$thum, Option::get('att_imgmaxw'), Option::get('att_imgmaxh'))) {
			$file_info['thum_file'] = $thum;
			$file_info['thum_size'] = filesize(EMLOG_ROOT."/content/".$thum);
			$size = getimagesize(EMLOG_ROOT."/content/".$thum);
			if ($size) {
				$file_info['thum_width'] = $size[0];
				$file_info['thum_height'] = $size[1];
			}
		}
	}

	if (@is_uploaded_file($tmpFile)) {
		if (@!move_uploaded_file($tmpFile, EMLOG_ROOT."/content/".$attachpath)) {
			@unlink($tmpFile);
			return '上传失败。文件上传目录(content/uploadfile)不可写'; 
		}
		@chmod($attachpath, 0777);
	}
	
	// 如果附件是图片需要提取宽高
	if (in_array($file_info['mime_type'], array('image/jpeg', 'image/png', 'image/gif', 'image/bmp'))) {
		$size = getimagesize(EMLOG_ROOT."/content/".$file_info['file_path']);
		if ($size) {
			$file_info['width'] = $size[0];
			$file_info['height'] = $size[1];
		}
	}
	return $file_info;
}
?>