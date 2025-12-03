<?php 
/**
 * 微语部分
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
			<?php if($tws){?>
			<div class="main-list">
			<?php 
			foreach($tws as $val){
			$img = empty($val['img']) ? "" : BLOG_URL.$val['img'];
			$userRow = $db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "user WHERE uid = ".$val['author']);
			?>
			  <article class="post style">
				<div class="bg_xx"><div class="bg"></div></div><!-- 背景 -->
				<div class="f-head">
					<div class="f-img">
						<img src="<?php echo $userRow["photo"]?BLOG_URL."content/".$userRow["photo"]:TEMPLATE_URL."images/avatar.jpg";?>">
					</div>
					<div class="f-info">
						<div class="f-title nowrap"><?php echo $userRow["nickname"]?$userRow["nickname"]:$userRow["username"];?></div>
						<div class="f-info-v">
							<span class="time"><?php echo $val['date'];?></span>
						</div>
					</div>
				</div>
				<div class="f-content">
					<p style="-webkit-line-clamp: initial;"><?php echo $val['t'];?></p>
					<?php if($img){?>
					<a href="<?php echo $img;?>" no-pjax><img src="<?php echo TEMPLATE_URL; ?>images/load.gif" data-src="<?php echo $img;?>" class="img lazy"/></a>
					<?php }?>
				</div>
			  </article>
			  <!-- main-list post -->
			<?php
			}
			?>
			</div>
			<div class="navigator style">
				<?php echo getPageUrl($twnum, $index_twnum, $page, BLOG_URL.'t/?page=');?>
			</div>
			<?php }else{?>
			<div class="main-list preview">
				<article class="post style">
					<div class="bg_xx"><div class="bg"></div></div><!-- 背景 -->
					<div class="no_result" style="text-align: center;">
						<p class="no_res_text" style="font-size: 30px;">这里什么都没有了</p>
					</div>
				</article>
			</div>
			<div class="navigator style">
				<div class="bg_xx"><div class="bg"></div></div><!-- 背景 -->
			</div>
			<?php }?>
			<?php include View::getView('footer');?>