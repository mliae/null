<?php 
/**
 * 用户中心
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 

$action = isset($_GET['action']) ? addslashes(trim($_GET['action'])) : '';
?>
<?php if(ISLOGIN){?>
	<div id="post-type" class="style">
		<ul>
			<li <?php if($action==""){?>class="current"<?php }?>><a class="post-type-link" href="<?php echo BLOG_URL; ?>?user">主页</a></li>
			<li <?php if($action=="info"){?>class="current"<?php }?>><a class="post-type-link" href="<?php echo BLOG_URL; ?>?user&action=info">资料</a></li>
			<li><a class="post-type-link" href="<?=BLOG_URL.ADMIN_DIR;?>/?action=logout">登出</a></li>
		</ul>
	</div>
	<style>
	table td{background-color:#fff;}
	table input{border:0px;width:100%;height:100%;}
	</style>
	<?php if($action==""){?>
	<div class="style user-item">
	  <div class="user_info">
		<li class="ptnum"><?php echo count_log_all(UID);?><span>发布文章</span></li>
		<li class="frinum"><span>&nbsp;</span></li>
		<li class="vitnum"><?php echo count_com_all(UID);?><span>收到评论</span></li>
	  </div>
	</div>
	<div class="main-list">
		<?php
		$options_cache = Option::getAll();
		extract($options_cache);

		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

		$pageurl = BLOG_URL."?user&page=";
		
		$sql = "SELECT * FROM ".DB_PREFIX."blog where type = 'blog' and author=".UID." order by date desc";
		$ret = $db->query($sql);
		$blogs = array();
		while ($row = $db->fetch_array($ret)) {
			$blogs[$row['gid']] = $row;
		}
		
		if($page<1){
			$page=1;
		}
		$blogNum=count($blogs);
		$total_pages = ceil($blogNum / $index_lognum);
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
		$blogArr = array_slice($blogs, ($page-1)*$index_lognum, $index_lognum);

		foreach($blogArr as $value){
			$imgsrc = preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $value['content'], $img);
			$imgsrc = !empty($img[1]) ? $img[1][0] : '';
			?>
			<article class="post style">
				<div class="f-head">
				 <div class="f-img">
					<img src="<?php if($value['thumbs'] != ''){ echo $value['thumbs']; }else{ if($imgsrc){ echo $imgsrc; }else{ echo $NullTwoOption["home_pic_url"]?$NullTwoOption["home_pic_url"]:TEMPLATE_URL."images/post.jpg"; }; }; ?>">
					<i class="icon Q-certify-3"></i>
				 </div>
				 <div class="f-info" id="ajax_a">
					 <div class="f-title nowrap">
						 <a href="<?=Url::log($value['gid']);?>"><?=$value['title'];?></a>
					 </div>
					 <div class="f-info-v">
						 <?=$value['hide']=="y"?"<span><font color='red'>屏蔽</font></span>":"";?>
						 <?=$value['checked']=="n"?"<span><font color='red'>审核中</font></span>":"";?>
						 <span><?=$value['views'];?>浏览</span>
						 <span><?=$value['comnum'];?>评论</span>
						 <span><?=$value['slzan'];?>点在赞</span>
						 <span class="time"><?php echo smartDate($value['date']); ?></span>
						 <span><a href="<?=BLOG_URL;?>?user&publish=<?=$value['gid'];?>">编辑</a></span>
					 </div>
				 </div>
				</div>
			</article>
			<?php
		}
		?>
	</div>
	<div class="navigator style">
		<?php echo getPageUrl($blogNum, $index_lognum, $page, $pageurl);?>
	</div>
	<?php }?>
	<?php
	if($action=="info"){
		$User_Model = new User_Model();
		$userInfo = $User_Model->getOneUser(UID);
		$imgsize = chImageSize($userInfo["photo"], Option::ICON_MAX_W, Option::ICON_MAX_H);
        $token = LoginAuth::genToken();
		?>
		<div class="style about-item">
			<form id="userInfoForm" action="" method="post" enctype="multipart/form-data">
				<h3 class="section-title">
					账号：<?=$userInfo["username"];?>
				</h3>
				<h3 class="section-title">
					<?php if($userInfo["photo"]){?>
					<img src="<?=BLOG_URL."content/".$userInfo["photo"];?>" width="<?=$imgsize["w"];?>" height="<?=$imgsize["h"];?>" style="border:1px solid #CCCCCC;padding:1px;" />
					<br /><a href="javascript: delAvatar('确认要删除该头像吗？','<?=$token;?>');">删除头像</a>
					<?php }else{?>
					<img src="<?php echo TEMPLATE_URL; ?>images/avatar.jpg" />
					<?php }?>
					<input type="hidden" name="photo" value="<?php echo $userInfo["photo"]; ?>"/>
					<div style="margin:10px 0px;">头像</div>
					<input name="avatar" type="file" accept="image/*" /><br />
					(支持JPG、PNG格式图片)
				</h3>
				<div class="bbbb">
					<input maxlength="30" style="width:250px;" value="<?php echo $userInfo["nickname"]; ?>" name="nickname" placeholder="昵称" />
				</div>
				<?php if($NullTwoOption["user_reg_mail_switch"]=="y"){?>
				<div class="bbbb">
					<input name="email" type="email" value="<?php echo $userInfo["email"]; ?>" style="width:250px;" maxlength="30" placeholder="邮箱" />
				</div>
				<div class="bbbb">
					<input name="emailcode" style="width:250px;" maxlength="6" placeholder="邮箱验证码" />
					<button class="btn" type="button" id="sendMailCode">获取验证码</button>
				</div>
				<?php }?>
				<?php if(Option::EMLOG_VERSION>="6.0.1"){?>
				<div class="bbbb">
					<input name="website" type="url" id="website" value="<?php echo $userInfo["website"] ?>" style="width:250px;" maxlength="75" placeholder="网址" />
				</div>
				<?php }?>
				<div class="bbbb">
					<textarea name="description" style="height:65px;width: 250px;float: left;border: 0;border-bottom: 1px dashed #ddd;border-radius: 0;" type="text" placeholder="个人描述" maxlength="255"><?php echo $userInfo["description"]; ?></textarea>
				</div>
				<div class="bbbb">
					<input type="password" maxlength="30" style="width:250px;" value="" name="newpass" placeholder="新密码（不小于6位，不修改请留空）" />
				</div>
				<div class="bbbb">
					<input type="password" placeholder="再输入一次新密码" maxlength="30" style="width:250px;" value="" name="repeatpass" />
				</div>
				<?php if($NullTwoOption["user_reg_mail_switch"]=="y"&&$login_code=="y"){?>
				<div class="bbbb">
					<input name="imgcode" type="text" size="5" maxlength="5" tabindex="5" placeholder="验证码" />
					<img onclick="this.src='<?=BLOG_URL;?>include/lib/checkcode.php?id='+Math.random()" src="<?=BLOG_URL;?>include/lib/checkcode.php" align="absmiddle" />
				</div>
				<?php }?>
				<input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
				<input class="btn" type="submit" value="保存资料" class="layui-btn" />
			</form>
		</div>
		<script>
		if($.cookie("updateMailCodeCookie")){
			var count=$.cookie("updateMailCodeCookie");
			$('#sendMailCode').attr('disabled',true);
			$('#sendMailCode').text(count+'秒');
			var resend = setInterval(function(){
				count--;
				if (count > 0){
					$('#sendMailCode').text(count+'秒');
					$.cookie("updateMailCodeCookie", count, {path: '/', expires: (1/86400)*count});
				}else {
					$('#sendMailCode').attr('disabled', false);
					clearInterval(resend);
					$('#sendMailCode').text("获取验证码");
				}
			}, 1000);
		}
		$("#sendMailCode").click(function(){
			if($('#sendMailCode').text()!="获取验证码"){
				return;
			}
			$.post("<?php echo TEMPLATE_URL; ?>ajax/user.php",{action:"sendMailCode",username:$("#userInfoForm input[name='email']").val(),imgcode:$("#userInfoForm input[name='imgcode']").val()},function(data){
				var data=JSON.parse(data);
				if(data.code==0){
					tips_update(data.msg);
					var count = 60; 
					var inl = setInterval(function () {
						$('#sendMailCode').attr('disabled', true); 
						count -= 1; 
						var text = count + ' 秒'; 
						$.cookie("updateMailCodeCookie", count, {path: '/', expires: (1/86400)*count});
						$('#sendMailCode').text(text); 
						if (count <= 0) {
							clearInterval(inl); 
							$('#sendMailCode').attr('disabled', false); 
							$('#sendMailCode').text('获取验证码'); 
						}
					}, 1000);
				}else{
					tips_update(data.msg);
				}
			});
		});
		$("#userInfoForm").submit(function(){
			var formData = new FormData($("#userInfoForm")[0]);
			formData.append("avatar",$("#userInfoForm input[name='avatar']")[0].files[0]);
			formData.append("token",$("#token").val());
			formData.append("action","updateUserInfo");
			$.ajax({
				url:"<?php echo TEMPLATE_URL; ?>ajax/user.php",
				type: 'POST',
				data: formData,
				dataType:"text",
				contentType: false,
				processData: false,
				success:function(data){
					if(isJSON(data)){
						var data=JSON.parse(data);
						if(data.code==0){
							tips_update(data.msg);
							pjax.loadUrl(data.url);
						}else{
							tips_update(data.msg);
						}
					}else{
						var pattern = /token error/;
						if(pattern.test(data)) {
							tips_update("修改失败，权限不足，请前台登陆。");
							return;
						}
						tips_update("修改失败");
					}
				}
			});
			return false;
		});
		function delAvatar(msg,token){
			if(confirm(msg)){
				$.post("<?php echo TEMPLATE_URL; ?>ajax/user.php",{action:"ajax_avatar_del",token:token},function(data){
					if(isJSON(data)){
						var data=JSON.parse(data);
						if(data.code==0){
							pjax.loadUrl(data.url);
						}
					}else{
						var pattern = /token error/;
						if(pattern.test(data)) {
							tips_update("删除失败，权限不足，请前台登陆。");
							return;
						}
						tips_update("删除失败");
					}
				});
			}
		}
		function isJSON(str) {
			if (typeof str == 'string') {
				try {
					var obj=JSON.parse(str);
					if(typeof obj == 'object' && obj ){
						return true;
					}else{
						return false;
					}
				} catch(e) {
					return false;
				}
			}
		}
		</script>
		<?php
	}
	?>
<?php }else{?>
	<?php include View::getView('user/login'); ?>
<?php }?>
<?php include View::getView('footer'); ?>