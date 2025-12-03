<?php 
/**
 * @NullTwoForEmlog
 * @author 二呆(www.tongleer.com)
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 

if(ROLE==ROLE_ADMIN){
	$page = isset($_GET['page']) ? addslashes(trim($_GET['page'])) : '';
	if($_POST){
		$action = isset($_POST['action']) ? addslashes(trim($_POST['action'])) : '';
		switch($action){
			case "basic":
				$admin_dir = isset($_POST['admin_dir']) ? addslashes(trim($_POST['admin_dir'])) : 'admin';
				$website_date = isset($_POST['website_date']) ? addslashes(trim($_POST['website_date'])) : date("Y-m-d");
				$webpage_color = isset($_POST['webpage_color']) ? addslashes(trim($_POST['webpage_color'])) : '';
				$webpage_color_sub = isset($_POST['webpage_color_sub']) ? addslashes(trim($_POST['webpage_color_sub'])) : '';
				$notice = isset($_POST['notice']) ? addslashes(trim($_POST['notice'])) : '';
				$mobile_side_bg = isset($_POST['mobile_side_bg']) ? addslashes(trim($_POST['mobile_side_bg'])) : '';
				$is_referrer = isset($_POST['is_referrer']) ? addslashes(trim($_POST['is_referrer'])) : 'n';
				$is_like = isset($_POST['is_like']) ? addslashes(trim($_POST['is_like'])) : 'n';
				$is_visitor_ranking = isset($_POST['is_visitor_ranking']) ? addslashes(trim($_POST['is_visitor_ranking'])) : 'n';
				$album_id = isset($_POST['album_id']) ? addslashes(trim($_POST['album_id'])) : '';
				$album_source = isset($_POST['album_source']) ? addslashes(trim($_POST['album_source'])) : '';
				$home_recommend = isset($_POST['home_recommend']) ? trim($_POST['home_recommend']) : '';
				$foot_custom_info = isset($_POST['foot_custom_info']) ? trim($_POST['foot_custom_info']) : '';
				$player_switch = isset($_POST['player_switch']) ? addslashes(trim($_POST['player_switch'])) : 'n';
				$player_is_auto = isset($_POST['player_is_auto']) ? addslashes(trim($_POST['player_is_auto'])) : 'n';
				$player_color = isset($_POST['player_color']) ? addslashes(trim($_POST['player_color'])) : '#009688';
				$player_list_id = isset($_POST['player_list_id']) ? addslashes(trim($_POST['player_list_id'])) : '503672348';
				$home_pic_switch = isset($_POST['home_pic_switch']) ? addslashes(trim($_POST['home_pic_switch'])) : 'n';
				$home_pic_url = isset($_POST['home_pic_url']) ? addslashes(trim($_POST['home_pic_url'])) : '';
				$home_pic_other = isset($_POST['home_pic_other']) ? addslashes(trim($_POST['home_pic_other'])) : '';
				
				if(get_magic_quotes_gpc()){
					$admin_dir = stripslashes($admin_dir);
					$website_date = stripslashes($website_date);
					$webpage_color = stripslashes($webpage_color);
					$webpage_color_sub = stripslashes($webpage_color_sub);
					$notice = stripslashes($notice);
					$mobile_side_bg = stripslashes($mobile_side_bg);
					$is_referrer = stripslashes($is_referrer);
					$is_like = stripslashes($is_like);
					$is_visitor_ranking = stripslashes($is_visitor_ranking);
					$album_id = stripslashes($album_id);
					$album_source = stripslashes($album_source);
					$home_recommend = stripslashes($home_recommend);
					$foot_custom_info = stripslashes($foot_custom_info);
					$player_switch = stripslashes($player_switch);
					$player_is_auto = stripslashes($player_is_auto);
					$player_color = stripslashes($player_color);
					$player_list_id = stripslashes($player_list_id);
					$home_pic_switch = stripslashes($home_pic_switch);
					$home_pic_url = stripslashes($home_pic_url);
					$home_pic_other = stripslashes($home_pic_other);
				}
				
				$NullTwoOption["admin_dir"]=$admin_dir;
				$NullTwoOption["website_date"]=$website_date;
				$NullTwoOption["webpage_color"]=$webpage_color;
				$NullTwoOption["webpage_color_sub"]=$webpage_color_sub;
				$NullTwoOption["notice"]=$notice;
				$NullTwoOption["mobile_side_bg"]=$mobile_side_bg;
				$NullTwoOption["is_referrer"]=$is_referrer;
				$NullTwoOption["is_like"]=$is_like;
				$NullTwoOption["is_visitor_ranking"]=$is_visitor_ranking;
				$NullTwoOption["album_id"]=$album_id;
				$NullTwoOption["album_source"]=$album_source;
				$NullTwoOption["home_recommend"]=$home_recommend;
				$NullTwoOption["foot_custom_info"]=$foot_custom_info;
				$NullTwoOption["player_switch"]=$player_switch;
				$NullTwoOption["player_is_auto"]=$player_is_auto;
				$NullTwoOption["player_color"]=$player_color;
				$NullTwoOption["player_list_id"]=$player_list_id;
				$NullTwoOption["home_pic_switch"]=$home_pic_switch;
				$NullTwoOption["home_pic_url"]=$home_pic_url;
				$NullTwoOption["home_pic_other"]=$home_pic_other;
				break;
			case "info":
				$info_qrcode = isset($_POST['info_qrcode']) ? addslashes(trim($_POST['info_qrcode'])) : '';
				$info_face = isset($_POST['info_face']) ? addslashes(trim($_POST['info_face'])) : '';
				$info_nick = isset($_POST['info_nick']) ? addslashes(trim($_POST['info_nick'])) : '';
				$info_desc = isset($_POST['info_desc']) ? addslashes(trim($_POST['info_desc'])) : '';
				$info_qq = isset($_POST['info_qq']) ? addslashes(trim($_POST['info_qq'])) : '';
				$info_weixin = isset($_POST['info_weixin']) ? addslashes(trim($_POST['info_weixin'])) : '';
				$info_website = isset($_POST['info_website']) ? addslashes(trim($_POST['info_website'])) : '';
				$info_mail = isset($_POST['info_mail']) ? addslashes(trim($_POST['info_mail'])) : '';
				$alipay_qrcode = isset($_POST['alipay_qrcode']) ? addslashes(trim($_POST['alipay_qrcode'])) : '';
				$wxpay_qrcode = isset($_POST['wxpay_qrcode']) ? addslashes(trim($_POST['wxpay_qrcode'])) : '';
				$qqpay_qrcode = isset($_POST['qqpay_qrcode']) ? addslashes(trim($_POST['qqpay_qrcode'])) : '';
				
				if(get_magic_quotes_gpc()){
					$info_qrcode = stripslashes($info_qrcode);
					$info_face = stripslashes($info_face);
					$info_nick = stripslashes($info_nick);
					$info_desc = stripslashes($info_desc);
					$info_qq = stripslashes($info_qq);
					$info_weixin = stripslashes($info_weixin);
					$info_website = stripslashes($info_website);
					$info_mail = stripslashes($info_mail);
					$alipay_qrcode = stripslashes($alipay_qrcode);
					$wxpay_qrcode = stripslashes($wxpay_qrcode);
					$qqpay_qrcode = stripslashes($qqpay_qrcode);
				}
				
				$NullTwoOption["info_qrcode"]=$info_qrcode;
				$NullTwoOption["info_face"]=$info_face;
				$NullTwoOption["info_nick"]=$info_nick;
				$NullTwoOption["info_desc"]=$info_desc;
				$NullTwoOption["info_qq"]=$info_qq;
				$NullTwoOption["info_weixin"]=$info_weixin;
				$NullTwoOption["info_website"]=$info_website;
				$NullTwoOption["info_mail"]=$info_mail;
				$NullTwoOption["alipay_qrcode"]=$alipay_qrcode;
				$NullTwoOption["wxpay_qrcode"]=$wxpay_qrcode;
				$NullTwoOption["qqpay_qrcode"]=$qqpay_qrcode;
				break;
			case "user":
				$user_login_switch = isset($_POST['user_login_switch']) ? addslashes(trim($_POST['user_login_switch'])) : 'n';
				$user_reg_switch = isset($_POST['user_reg_switch']) ? addslashes(trim($_POST['user_reg_switch'])) : 'n';
				$user_reg_mail_switch = isset($_POST['user_reg_mail_switch']) ? addslashes(trim($_POST['user_reg_mail_switch'])) : 'n';
				
				if(get_magic_quotes_gpc()){
					$user_login_switch = stripslashes($user_login_switch);
					$user_reg_switch = stripslashes($user_reg_switch);
					$user_reg_mail_switch = stripslashes($user_reg_mail_switch);
				}
				
				$NullTwoOption["user_login_switch"]=$user_login_switch;
				$NullTwoOption["user_reg_switch"]=$user_reg_switch;
				$NullTwoOption["user_reg_mail_switch"]=$user_reg_mail_switch;
				break;
			case "ad":
				$ad_left = isset($_POST['ad_left']) ? addslashes(trim($_POST['ad_left'])) : '';
				$ad_right = isset($_POST['ad_right']) ? addslashes(trim($_POST['ad_right'])) : '';
				
				if(get_magic_quotes_gpc()){
					$ad_left = stripslashes($ad_left);
					$ad_right = stripslashes($ad_right);
				}
				
				$NullTwoOption["ad_left"]=$ad_left;
				$NullTwoOption["ad_right"]=$ad_right;
				break;
		}
		$db->query("UPDATE `".DB_PREFIX."options` SET `option_value`='".addslashes(serialize($NullTwoOption))."' WHERE `option_name`='theme:NullTwo'");
		$CACHE->updateCache(array("options","logalias"));
		echo "<script>alert('修改配置成功');location.href='".BLOG_URL."?setting';</script>";
	}
	?>
	<div id="post-type" class="style">
		<ul>
			<li <?php if($page==""){?>class="current"<?php }?>><a class="post-type-link" href="<?php echo BLOG_URL; ?>?setting&page=">基础</a></li>
			<li <?php if($page=="info"){?>class="current"<?php }?>><a class="post-type-link" href="<?php echo BLOG_URL; ?>?setting&page=info">资料</a></li>
			<li <?php if($page=="user"){?>class="current"<?php }?>><a class="post-type-link" href="<?php echo BLOG_URL; ?>?setting&page=user">用户</a></li>
			<li <?php if($page=="ad"){?>class="current"<?php }?>><a class="post-type-link" href="<?php echo BLOG_URL; ?>?setting&page=ad">广告</a></li>
			<li <?php if($page=="about"){?>class="current"<?php }?>><a class="post-type-link" href="<?php echo BLOG_URL; ?>?setting&page=about">关于</a></li>
		</ul>
	</div>
	<style>
	table td{background-color:#fff;}
	table input[type="text"],table textarea{border:0px;width:100%;height:100%;}
	</style>
	<?php if($page==""){?>
	<div class="main-list">
		<form action="" method="post">
			<article class="post style">
				<table width="100%" border="0" bgcolor="#eee" cellpadding="1" cellspacing="1">
					<tr><th colspan="2">参数</th></tr>
					<tr>
						<td align="center" width="50%">后台目录名</td>
						<td>
							<input name="admin_dir" type="text" value="<?=$NullTwoOption["admin_dir"]?$NullTwoOption["admin_dir"]:"admin";?>" maxlength="20" placeholder="">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">建站日期</td>
						<td>
							<input name="website_date" type="text" value="<?=$NullTwoOption["website_date"]?$NullTwoOption["website_date"]:date("Y-m-d");?>" maxlength="10" placeholder="填写格式：<?=date("Y");?>">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">网页主色</td>
						<td>
							<input name="webpage_color" type="text" value="<?=$NullTwoOption["webpage_color"]?$NullTwoOption["webpage_color"]:"";?>" maxlength="10" placeholder="设置空默认颜色为#009688">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">网页副色</td>
						<td>
							<input name="webpage_color_sub" type="text" value="<?=$NullTwoOption["webpage_color_sub"]?$NullTwoOption["webpage_color_sub"]:"";?>" maxlength="10" placeholder="设置空默认颜色为#9c51ff">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">公告</td>
						<td>
							<input name="notice" type="text" value="<?=$NullTwoOption["notice"]?$NullTwoOption["notice"]:"";?>" maxlength="255" placeholder="">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">手机侧边栏背景</td>
						<td>
							<input name="mobile_side_bg" type="text" value="<?=$NullTwoOption["mobile_side_bg"]?$NullTwoOption["mobile_side_bg"]:"";?>" maxlength="255" placeholder="填写背景图片地址">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">头部是否添加<a href="javascript:;" title="添加referrer以防止微博等图片受防盗链影响"><b style="font-weight:bold;">referrer</b></a></td>
						<td>
							<input type="radio"  value="y" name="is_referrer" <?php if($NullTwoOption["is_referrer"]=='y'){?>checked<?php }?>> 是
							<input type="radio" value="n" name="is_referrer" <?php if($NullTwoOption["is_referrer"]!='y'){?>checked<?php }?>> 否
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">是否显示喜欢你</td>
						<td>
							<input type="radio"  value="y" name="is_like" <?php if($NullTwoOption["is_like"]=='y'){?>checked<?php }?>> 是
							<input type="radio" value="n" name="is_like" <?php if($NullTwoOption["is_like"]!='y'){?>checked<?php }?>> 否
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">是否显示访客排行</td>
						<td>
							<input type="radio"  value="y" name="is_visitor_ranking" <?php if($NullTwoOption["is_visitor_ranking"]=='y'){?>checked<?php }?>> 是
							<input type="radio" value="n" name="is_visitor_ranking" <?php if($NullTwoOption["is_visitor_ranking"]!='y'){?>checked<?php }?>> 否
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">指定相册分类ID<br />（多个分类ID用|逗号隔开）</td>
						<td>
							<input name="album_id" type="text" value="<?=$NullTwoOption["album_id"]?$NullTwoOption["album_id"]:"";?>" placeholder="填写如1|2的形式">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">指定相册来源</td>
						<td>
							<select name="album_source">
								<option value="" <?=$NullTwoOption["album_source"]==""?"selected":"";?>>内容</option>
								<option value="attach" <?=$NullTwoOption["album_source"]=="attach"?"selected":"";?>>附件</option>
								<option value="all" <?=$NullTwoOption["album_source"]=="all"?"selected":"";?>>内容+附件</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">首页推荐(<a id="home_recommend_text" href="javascript:$('#home_recommend').val($('#home_recommend_text').attr('title'));" title='
	[{
	"pic":"",
	"link":""
	},{
	"pic":"",
	"link":""
	},{
	"pic":"",
	"link":""
	}]
							'><font color="red">插入格式</font></a>)</td>
						<td>
							<textarea id="home_recommend" name="home_recommend" rows="5" placeholder=""><?=$NullTwoOption["home_recommend"]?$NullTwoOption["home_recommend"]:'';?></textarea>
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">自定义底部信息</td>
						<td>
							<textarea id="foot_custom_info" name="foot_custom_info" rows="5" placeholder=""><?=$NullTwoOption["foot_custom_info"]?$NullTwoOption["foot_custom_info"]:'';?></textarea>
						</td>
					</tr>
				</table>
			</article>
			<article class="post style">
				<table width="100%" border="0" bgcolor="#eee" cellpadding="1" cellspacing="1">
					<tr><th colspan="2">网易云播放器</th></tr>
					<tr>
						<td align="center" width="50%">是否开启</td>
						<td>
							<input type="radio"  value="y" name="player_switch" <?php if($NullTwoOption["player_switch"]=='y'){?>checked<?php }?>> 开启
							<input type="radio" value="n" name="player_switch" <?php if($NullTwoOption["player_switch"]!='y'){?>checked<?php }?>> 关闭
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">是否自动播放</td>
						<td>
							<input type="radio"  value="y" name="player_is_auto" <?php if($NullTwoOption["player_is_auto"]=='y'){?>checked<?php }?>> 是
							<input type="radio" value="n" name="player_is_auto" <?php if($NullTwoOption["player_is_auto"]!='y'){?>checked<?php }?>> 否
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">播放器颜色</td>
						<td>
							<input name="player_color" type="text" value="<?=$NullTwoOption["player_color"]?$NullTwoOption["player_color"]:"#009688";?>" maxlength="10" placeholder="默认为#009688">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">播放歌单ID</td>
						<td>
							<input name="player_list_id" type="text" value="<?=$NullTwoOption["player_list_id"]?$NullTwoOption["player_list_id"]:"503672348";?>" maxlength="10" placeholder="默认为503672348">
						</td>
					</tr>
				</table>
			</article>
			<article class="post style">
				<table width="100%" border="0" bgcolor="#eee" cellpadding="1" cellspacing="1">
					<tr><th colspan="2">首页大图</th></tr>
					<tr>
						<td align="center" width="50%">是否显示</td>
						<td>
							<input type="radio"  value="y" name="home_pic_switch" <?php if($NullTwoOption["home_pic_switch"]=='y'){?>checked<?php }?>> 显示
							<input type="radio" value="n" name="home_pic_switch" <?php if($NullTwoOption["home_pic_switch"]!='y'){?>checked<?php }?>> 隐藏
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">默认大图地址</td>
						<td>
							<input name="home_pic_url" type="text" value="<?=$NullTwoOption["home_pic_url"]?$NullTwoOption["home_pic_url"]:"";?>" placeholder="填写图片地址">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">大图切换地址<br />（多个大图用|逗号隔开）</td>
						<td>
							<input name="home_pic_other" type="text" value="<?=$NullTwoOption["home_pic_other"]?$NullTwoOption["home_pic_other"]:"";?>" placeholder="填写如http://xxx/x.jpg|http://xxx/x.jpg的形式">
						</td>
					</tr>
				</table>
				<input type="hidden" name="action" value="basic" />
				<button class="btn" type="submit">保存配置</button>
			
			</article>
		</form>
	</div>
	<?php }?>
	<?php if($page=="info"){?>
	<div class="main-list">
		<article class="post style">
			<form action="" method="post">
				<table width="100%" border="0" bgcolor="#eee" cellpadding="1" cellspacing="1">
					<tr>
						<td align="center" width="50%">个人二维码</td>
						<td>
							<input name="info_qrcode" type="text" value="<?=$NullTwoOption["info_qrcode"]?$NullTwoOption["info_qrcode"]:"";?>" placeholder="填写个人二维码图片地址">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">网站头像</td>
						<td>
							<input name="info_face" type="text" value="<?=$NullTwoOption["info_face"]?$NullTwoOption["info_face"]:"";?>" placeholder="填写网站头像图片地址">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">网站昵称</td>
						<td>
							<input name="info_nick" type="text" value="<?=$NullTwoOption["info_nick"]?$NullTwoOption["info_nick"]:"";?>" placeholder="填写网站昵称">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">网站描述</td>
						<td>
							<input name="info_desc" type="text" value="<?=$NullTwoOption["info_desc"]?$NullTwoOption["info_desc"]:"";?>" placeholder="填写网站描述">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">网站QQ</td>
						<td>
							<input name="info_qq" type="text" value="<?=$NullTwoOption["info_qq"]?$NullTwoOption["info_qq"]:"";?>" placeholder="填写网站QQ">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">网站微信</td>
						<td>
							<input name="info_weixin" type="text" value="<?=$NullTwoOption["info_weixin"]?$NullTwoOption["info_weixin"]:"";?>" placeholder="填写网站微信">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">网站网址</td>
						<td>
							<input name="info_website" type="text" value="<?=$NullTwoOption["info_website"]?$NullTwoOption["info_website"]:"";?>" placeholder="填写网站网址">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">网站邮箱</td>
						<td>
							<input name="info_mail" type="text" value="<?=$NullTwoOption["info_mail"]?$NullTwoOption["info_mail"]:"";?>" placeholder="填写个人邮箱地址">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">支付宝钱包二维码</td>
						<td>
							<input name="alipay_qrcode" type="text" value="<?=$NullTwoOption["alipay_qrcode"]?$NullTwoOption["alipay_qrcode"]:"";?>" placeholder="填写支付宝钱包二维码图片地址">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">微信钱包二维码</td>
						<td>
							<input name="wxpay_qrcode" type="text" value="<?=$NullTwoOption["wxpay_qrcode"]?$NullTwoOption["wxpay_qrcode"]:"";?>" placeholder="填写微信钱包二维码图片地址">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">QQ钱包二维码</td>
						<td>
							<input name="qqpay_qrcode" type="text" value="<?=$NullTwoOption["qqpay_qrcode"]?$NullTwoOption["qqpay_qrcode"]:"";?>" placeholder="填写QQ钱包二维码图片地址">
						</td>
					</tr>
				</table>
				<input type="hidden" name="action" value="info" />
				<button class="btn" type="submit">保存配置</button>
			</form>
		</article>
	</div>
	<?php }?>
	<?php if($page=="user"){?>
	<div class="main-list">
		<form action="" method="post">
			<article class="post style">
				<table width="100%" border="0" bgcolor="#eee" cellpadding="1" cellspacing="1">
					<tr>
						<td align="center" width="50%">前台登陆开关</td>
						<td>
							<input type="radio"  value="y" name="user_login_switch" <?php if($NullTwoOption["user_login_switch"]=='y'){?>checked<?php }?>> 开启
							<input type="radio" value="n" name="user_login_switch" <?php if($NullTwoOption["user_login_switch"]!='y'){?>checked<?php }?>> 关闭
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">前台注册开关</td>
						<td>
							<input type="radio"  value="y" name="user_reg_switch" <?php if($NullTwoOption["user_reg_switch"]=='y'){?>checked<?php }?>> 开启
							<input type="radio" value="n" name="user_reg_switch" <?php if($NullTwoOption["user_reg_switch"]!='y'){?>checked<?php }?>> 关闭
						</td>
					</tr>
					<?php if(Option::EMLOG_VERSION>="6.0.1"){?>
					<tr>
						<td align="center" width="50%">前台邮箱注册</td>
						<td>
							<input type="radio"  value="y" name="user_reg_mail_switch" <?php if($NullTwoOption["user_reg_mail_switch"]=='y'){?>checked<?php }?>> 开启
							<input type="radio" value="n" name="user_reg_mail_switch" <?php if($NullTwoOption["user_reg_mail_switch"]!='y'){?>checked<?php }?>> 关闭
						</td>
					</tr>
					<?php }?>
				</table>
			</article>
			<article class="post style">
				<table width="100%" border="0" bgcolor="#eee" cellpadding="1" cellspacing="1">
					
				</table>
				<input type="hidden" name="action" value="user" />
				<button class="btn" type="submit">保存配置</button>
			</article>
		</form>
	</div>
	<?php }?>
	<?php if($page=="ad"){?>
	<div class="main-list">
		<article class="post style">
			<form action="" method="post">
				<table width="100%" border="0" bgcolor="#eee" cellpadding="1" cellspacing="1">
					<tr>
						<td align="center" width="50%">左侧边栏广告</td>
						<td>
							<input name="ad_left" type="text" value="<?=$NullTwoOption["ad_left"]?$NullTwoOption["ad_left"]:"";?>" placeholder="填写格式：链接|图片地址。">
						</td>
					</tr>
					<tr>
						<td align="center" width="50%">右侧边栏广告</td>
						<td>
							<input name="ad_right" type="text" value="<?=$NullTwoOption["ad_right"]?$NullTwoOption["ad_right"]:"";?>" placeholder="填写格式：链接|图片地址。">
						</td>
					</tr>
				</table>
				<input type="hidden" name="action" value="ad" />
				<button class="btn" type="submit">保存配置</button>
			</form>
		</article>
	</div>
	<?php }?>
	<?php if($page=="about"){?>
	<div class="main-list">
		<article class="post style">
			页面模板包含：<br />
			page_album、page_archivers、page_link、page_lyb、page_sorts<br />
			
			<br />
			
			添加视频方式：<br />
			1、[video]mp4视频地址[/video]<br />
			2、[iframe]优酷视频地址[/iframe]<br />
			
			<br />
			
			打赏：<br />
			<img src="https://www.tongleer.com/api/web/pay.png" width="300" alt="" /><br />
			
			<br />
			
			微信公众号：Diamond0422<br />
			<img src="https://ws3.sinaimg.cn/large/005V7SQ5ly1g0vcv2g89yj305k05k3yu.jpg" width="100" alt="" />
		</article>
	</div>
	<?php }?>
	<?php include View::getView('footer'); ?>
	<?php
}else{
	header("Location:".BLOG_URL);
}
?>