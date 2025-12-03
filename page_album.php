<?php 
/*
Custom:page_album
Description:相册
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
$db = Database::getInstance();

$album = isset($_GET['album']) ? intval($_GET['album']) : 0;
$photo = isset($_GET['photo']) ? intval($_GET['photo']) : 0;
?>
			<?php if($NullTwoOption["album_id"]){?>
				<div id="post-type" class="style">
					<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
					<ul>
						<?php
						$album_id=explode("|",$NullTwoOption["album_id"]);
						global $CACHE; 
						$sort_cache = $CACHE->readCache('sort');
						array_multisort(array_column($sort_cache,'taxis'),SORT_DESC,$sort_cache);
						$albumfirst=0;
						$sortkey=0;foreach($sort_cache as $row){
							if(!in_array($row['sid'],$album_id)){
								continue;
							}
							if($sortkey==0){
								$albumfirst=$row['sid'];
							}
						?>
						<li <?php if(($album==0&&$sortkey==0)||$album==$row['sid']){?>class="current"<?php }?>><a class="post-type-link" href="<?=Url::log($logid).(strpos(Url::log($logid),"?")?"&":"?")."album=".$row['sid'];?>" id="sort_id-<?=$row['sid'];?>"><?php echo $row['sortname'];?></a></li>
						<?php
						$sortkey++;}
						?>
					</ul>
				</div>
				<?php if(!$photo){?>
				<section class="style books">
					<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
					<?php
					$sortRow = $db->once_fetch_array("SELECT sortname,description FROM " . DB_PREFIX . "sort WHERE sid = ".($album?$album:$albumfirst));
					?>
					<header class="entry-header">
						<h1 class="title" itemprop="name"><?=$sortRow["sortname"]; ?></h1>
						<div class="meta"><?=$sortRow["description"]; ?></div>
					</header>
					<div class="single">
						<div id="gallery-3" class="gallery">
							<?php
							$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

							$pageurl = Url::log($logid).(strpos(Url::log($logid),"?")?"&":"?")."album=".($album?$album:$albumfirst);
							
							$sql = "SELECT gid,content FROM ".DB_PREFIX."blog where hide='n' and checked='y' and type='blog' and sortid = ".($album?$album:$albumfirst)." order by date desc";
							$ret = $db->query($sql);
							$albumblog = array();
							while ($row = $db->fetch_array($ret)) {
								if(getPostImg($row["gid"],$row['content'],false)){
									$albumblog[$row['gid']] = $row;
								}
							}
							$index_lognum=9;
							if($page<1){
								$page=1;
							}
							$albumNum=count($albumblog);
							$total_pages = ceil($albumNum / $index_lognum);
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
							$albumblogArr = array_slice($albumblog, ($page-1)*$index_lognum, $index_lognum);
							
							foreach($albumblogArr as $value){
								$albumImgs=getPostImg($value["gid"],$value['content'],false);
								if(count($albumImgs)>1){
									?>
									<dl class="gallery-item">
										<dt>
											<a href="<?=Url::log($logid).(strpos(Url::log($logid),"?")?"&":"?")."album=".$value['gid']."&photo=".$value["gid"];?>">
												<img src="<?=$albumImgs[0]["url"];?>" alt="<?=$albumImgs[0]["title"];?>" class="lazy">
												<div style="background: rgba(0, 0, 0, 0.5);font-size: 14px;position: absolute;bottom: 2%;right: 2%;text-align: center;color: #fff;padding: 0 5px;border-radius: 5px;"><?=count($albumImgs);?>P</div>
											</a>
										</dt>
									</dl>
									<?php
								}else if(count($albumImgs)==1){
									?>
									<dl class="gallery-item">
										<dt>
											<a target="_blank" href="<?=$albumImgs[0]["url"];?>" rel="nofollow" no-pjax>
												<img src="<?php echo TEMPLATE_URL; ?>images/load.gif" data-src="<?=$albumImgs[0]["url"];?>" alt="<?=$albumImgs[0]["title"];?>" class="lazy">
											</a>
										</dt>
									</dl>
									<?php
								}
							}
							?>
						</div>
						<?php if($albumblogArr){?>
						<ul>
						  <?php if($page!=1){?>
							<li><a href="<?=$pageurl;?>&page=1">首页</a></li>
						  <?php }?>
						  <?php if($page>1){?>
							<li><a href="<?=$pageurl;?>&page=<?=$before_page;?>">&laquo; 上一页</a></li>
						  <?php }?>
						  <?php if($page<$total_pages){?>
							<li><a href="<?=$pageurl;?>&page=<?=$after_page;?>">下一页 &raquo;</a></li>
						  <?php }?>
						  <?php if($page!=$total_pages){?>
							<li><a href="<?=$pageurl;?>&page=<?=$total_pages;?>">尾页</a></li>
						  <?php }?>
						</ul>
						<?php }?>
					</div>
				</section>
				<?php }else{?>
				<section class="style books">
					<div class="bg_xx"><div class="bg"></div></div><!-- 特别背景 -->
					<?php
					$sortRow = $db->once_fetch_array("SELECT sortname,description FROM " . DB_PREFIX . "sort WHERE sid = ".($album?$album:$albumfirst));
					?>
					<header class="entry-header">
						<h1 class="title" itemprop="name"><?=$sortRow["sortname"]; ?></h1>
						<div class="meta"><?=$sortRow["description"]; ?></div>
					</header>
					<div class="single">
						<div id="gallery-3" class="gallery">
							<?php
							$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

							$pageurl = Url::log($logid).(strpos(Url::log($logid),"?")?"&":"?")."album=".($album?$album:$albumfirst)."&photo=".$photo;
							
							$blogRow = $db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "blog WHERE gid = ".$photo);
							$albumImgs=getPostImg($blogRow["gid"],$blogRow['content'],false);
							
							$index_lognum=9;
							if($page<1){
								$page=1;
							}
							$albumImgNum=count($albumImgs);
							$total_pages = ceil($albumImgNum / $index_lognum);
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
							$albumImgsArr = array_slice($albumImgs, ($page-1)*$index_lognum, $index_lognum);
							
							foreach($albumImgsArr as $value){
								?>
								<dl class="gallery-item">
									<dt>
										<a target="_blank" href="<?=$value["url"];?>" rel="nofollow" no-pjax>
											<img src="<?php echo TEMPLATE_URL; ?>images/load.gif" data-src="<?=$value["url"];?>" alt="<?=$value["title"];?>" class="lazy">
										</a>
									</dt>
								</dl>
								<?php
							}
							?>
						</div>
						<ul>
						  <?php if($page!=1){?>
							<li><a href="<?=$pageurl;?>&page=1">首页</a></li>
						  <?php }?>
						  <?php if($page>1){?>
							<li><a href="<?=$pageurl;?>&page=<?=$before_page;?>">&laquo; 上一页</a></li>
						  <?php }?>
						  <?php if($page<$total_pages){?>
							<li><a href="<?=$pageurl;?>&page=<?=$after_page;?>">下一页 &raquo;</a></li>
						  <?php }?>
						  <?php if($page!=$total_pages){?>
							<li><a href="<?=$pageurl;?>&page=<?=$total_pages;?>">尾页</a></li>
						  <?php }?>
						</ul>
					</div>
				</section>
				<?php }?>
			<?php }else{?>
				<article class="post style">
					<div class="no_result" style="text-align: center;">
						<p class="no_res_text" style="font-size: 30px;">这里什么都没有了</p>
					</div>
				</article>
			<?php }?>
			<?php include View::getView('footer');?>