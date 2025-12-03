<?php 
/*
Custom:page_sorts
Description:专题
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
$db = Database::getInstance();
?>
<style>
.coimg {
    width: 60px;
	float:left;
	margin-right: 20px;
}
.coimg a {
    height: 60px;
    position: relative;
    display: block !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
    border-radius: 3px;
}
.cate-content {
	background: #fff;
	position:relative;
	padding: 20px 30px;
}

.cate-content ul {
    display: block;
	padding: 0;
    margin: 20px 0 50px;
}
.cate-content ul ul {
    margin: 0;
    margin-left: 45px;
}
.cate-content ul li {
	display: block;
	margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #F1F1F1;
}

.cate-content ul li a {
	font-size: 18px;
    color: rgb(53, 53, 53);
    display: inline-block;
}

.cate-content p {
	font-size: 13px;
    margin: 0;
    margin-top: 15px;
    color:#A5A5A5;
	overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
			<section class="style books">
				<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
				<header class="entry-header">
					<h1 class="title" itemprop="name"><?php echo $log_title; ?></h1>
					<div class="meta">发布于 <time itemprop="datePublished" datetime="<?php echo date('c', $date);?>"><?php echo date('Y年m月d日', $date);?></time> / <?php echo $comnum; ?> 条评论 / <?php blog_author($author); ?></div>
				</header>
				<div class="cate-content">
					<ul>
						<?php
						$sql = "SELECT * FROM ".DB_PREFIX."sort WHERE pid=0 ORDER BY taxis DESC";
						$ret = $db->query($sql);
						$sort = array();
						while ($row = $db->fetch_array($ret)) {
							$row['poster'] = htmlspecialchars($row['poster']);
							$row['mail'] = htmlspecialchars($row['mail']);
							$row['url'] = htmlspecialchars($row['url']);
							$sort[$row['sid']] = $row;
						}
						foreach($sort as $value){
						?>
						<li>
							<div class="coimg">
								<a href="<?=Url::sort($value["sid"]);?>" style="background: url(https://www.tongleer.com/api/web/?action=img);"></a>
							</div>
							<a href="<?=Url::sort($value["sid"]);?>" aria-label="<?=$value["description"];?>" class="hint--right"><?=$value["sortname"];?></a>
							<p><?=$value["description"];?></p>
						</li>
						<?php
						}
						?>
					</ul>
				</div>
			</section>
			<?php include View::getView('footer');?>