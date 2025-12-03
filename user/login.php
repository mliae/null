<?php 
/**
 * 登陆注册
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<style>
.loginput{
	margin:0 auto;
    width: 33.333%;
	height:30px;
    border: 1px dashed #ddd;
    border-radius: 10;
}
</style>
<?php if(!isset($_GET["register"])){?>
<div class="main-list">
	<article class="post style" style="text-align:center;">
		<form id="loginForm" action="" method="post">
			<div>
				<input class="loginput" name="user" type="text" value="" size="30" maxlength="30" required="required" placeholder="用户名">
			</div>
			<div>
				<input class="loginput" name="pw" type="password" value="" size="30" maxlength="30" required="required" placeholder="密码">
			</div>
			<?php if($login_code=="y"){?>
			<div>
				<input class="loginput" name="imgcode" type="text" size="5" maxlength="5" tabindex="5" placeholder="验证码" />
			</div>
			<?php }?>
			<table align="center" class="loginput">
				<tr>
					<td width="50%"><input type="checkbox" id="ispersis" name="ispersis" title="记住密码"><small style="font-size:9pt;">记住密码</small></td>
					<?php if($login_code=="y"){?>
					<td width="50%"><img onclick="this.src='<?=BLOG_URL;?>include/lib/checkcode.php?id='+Math.random()" src="<?=BLOG_URL;?>include/lib/checkcode.php" align="absmiddle" /></td>
					<?php }?>
				</tr>
			</table>
			<div>
				<button class="btn" type="submit">登入</button>
				<?php if($NullTwoOption["user_reg_switch"]=="y"){?>
				<a href="<?=BLOG_URL."?user&register";?>" class="btn"><?php if($NullTwoOption["user_reg_mail_switch"]=="y"){echo "邮箱";}?>注册</a>
				<?php }?>
			</div>
		</form>
	</article>
</div>
<?php }else if($NullTwoOption["user_reg_switch"]=="y"){?>
<div class="main-list">
	<article class="post style" style="text-align:center;">
		<form id="regForm" action="" method="post">
			<div>
				<input class="loginput" name="user" type="text" value="" size="30" maxlength="30" required="required" placeholder="用户名<?php if($NullTwoOption["user_reg_mail_switch"]=="y"){echo "/邮箱";}?>">
			</div>
			<?php if($NullTwoOption["user_reg_mail_switch"]=="y"){?>
			<table align="center" class="loginput">
				<tr>
					<td width="50%">
						<input style="height:30px;border: 1px dashed #ddd;border-radius: 10;" name="mailcode" type="text" size="6" maxlength="6" tabindex="5" placeholder="邮箱验证码" />
					</td>
					<td width="50%">
						<button id="mailCodeBtn" class="btn" type="button">获取验证码</button>
					</td>
				</tr>
			</table>
			<?php }?>
			<div>
				<input class="loginput" name="pw" type="password" value="" size="30" maxlength="30" required="required" placeholder="密码">
			</div>
			<div>
				<input class="loginput" name="repass" type="password" value="" size="30" maxlength="30" required="required" placeholder="确认密码">
			</div>
			<div>
				<input class="loginput" name="nickname" type="text" value="" size="30" maxlength="10" placeholder="昵称(选填)">
			</div>
			<?php if($login_code=="y"){?>
			<div>
				<input class="loginput" name="imgcode" type="text" size="5" maxlength="5" tabindex="5" placeholder="验证码" />
			</div>
			<table align="center" class="loginput">
				<tr>
					<td><img onclick="this.src='<?=BLOG_URL;?>include/lib/checkcode.php?id='+Math.random()" src="<?=BLOG_URL;?>include/lib/checkcode.php" align="absmiddle" /></td>
				</tr>
			</table>
			<?php }?>
			<div>
				<button class="btn" type="submit"><?php if($NullTwoOption["user_reg_mail_switch"]=="y"){echo "邮箱";}?>注册</button>
				<a href="<?=BLOG_URL;?>?user" class="btn">登入</a>
			</div>
		</form>
	</article>
</div>
<?php }?>
<script>
try{$("#loginForm input[name='user'],#regForm input[name='user']").focus();}catch(e){}
$("#loginForm").submit(function(){
	$.post("<?php echo TEMPLATE_URL; ?>ajax/user.php",{action:"login",username:$("#loginForm input[name='user']").val(),password:$("#loginForm input[name='pw']").val(),imgcode:$("#loginForm input[name='imgcode']").val(),ispersis:$("#loginForm input[name='ispersis']:checked").val()},function(data){
		var data=JSON.parse(data);
		if(data.code==0){
			pjax.loadUrl(data.url);
		}else{
			tips_update(data.msg);
		}
	});
	return false;
});
$("#regForm").submit(function(){
	$.post("<?php echo TEMPLATE_URL; ?>ajax/user.php",{action:"reg",username:$("#regForm input[name='user']").val(),password:$("#regForm input[name='pw']").val(),repass:$("#regForm input[name='repass']").val(),nickname:$("#regForm input[name='nickname']").val(),imgcode:$("#regForm input[name='imgcode']").val(),mailcode:$("#regForm input[name='mailcode']").val()},function(data){
		var data=JSON.parse(data);
		if(data.code==0){
			pjax.loadUrl(data.url);
		}else{
			tips_update(data.msg);
		}
	});
	return false;
});

if($.cookie("mailCodeCookie")){
	var count=$.cookie("mailCodeCookie");
	$('#mailCodeBtn').attr('disabled',true);
	$('#mailCodeBtn').text(count+'秒');
	var resend = setInterval(function(){
		count--;
		if (count > 0){
			$('#mailCodeBtn').text(count+'秒');
			$.cookie("mailCodeCookie", count, {path: '/', expires: (1/86400)*count});
		}else {
			$('#mailCodeBtn').attr('disabled', false);
			clearInterval(resend);
			$('#mailCodeBtn').text("获取验证码");
		}
	}, 1000);
}
$("#mailCodeBtn").click(function(){
	if($('#mailCodeBtn').text()!="获取验证码"){
		return;
	}
	$.post("<?php echo TEMPLATE_URL; ?>ajax/user.php",{action:"sendMailCode",username:$("#regForm input[name='user']").val(),imgcode:$("#regForm input[name='imgcode']").val()},function(data){
		var data=JSON.parse(data);
		if(data.code==0){
			tips_update(data.msg);
			var count = 60; 
			var inl = setInterval(function () {
				$('#mailCodeBtn').attr('disabled', true); 
				count -= 1; 
				var text = count + ' 秒'; 
				$.cookie("mailCodeCookie", count, {path: '/', expires: (1/86400)*count});
				$('#mailCodeBtn').text(text); 
				if (count <= 0) {
					clearInterval(inl); 
					$('#mailCodeBtn').attr('disabled', false); 
					$('#mailCodeBtn').text('获取验证码'); 
				}
			}, 1000);
		}else{
			tips_update(data.msg);
		}
	});
});
</script>