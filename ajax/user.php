<?php 
session_start();
require_once '../../../../init.php';
require_once '../module.php';
date_default_timezone_set("Etc/GMT-8");

$action = isset($_POST['action']) ? addslashes(trim($_POST['action'])) : '';
if($action=="ajax_avatar_get"){
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
	echo eflyGravatar($email);
	exit;
}else if($action=="ajax_avatar_del"){
	$db = Database::getInstance();
	LoginAuth::checkToken();
	
	$query = $db->query("select photo from ".DB_PREFIX."user where uid=" . UID);
	$icon = $db->fetch_array($query);
	$icon_1 = EMLOG_ROOT."/content/".$icon['photo'];
	if (file_exists($icon_1)) {
		$icon_2 = str_replace('thum-', '', $icon_1);
		if ($icon_2 != $icon_1 && file_exists($icon_2)) {
			@unlink($icon_2);
		}
		$icon_3 = preg_replace("/^(.*)\/(.*)$/", "\$1/thum52-\$2", $icon_2);
		if ($icon_3 != $icon_2 && file_exists($icon_3)) {
			@unlink($icon_3);
		}
		@unlink($icon_1);
	}
	$db->query("UPDATE ".DB_PREFIX."user SET photo='' where uid=" . UID);
	$CACHE->updateCache('user');
	echo jsonEncode(array("code"=>0,"msg"=>"删除头像成功","url"=>BLOG_URL."?user&action=info"));exit;
}else if($action=="updateUserInfo"){
	$db = Database::getInstance();
	LoginAuth::checkToken();
	$User_Model = new User_Model();
	
	$photo = isset($_POST['photo']) ? addslashes(trim($_POST['photo'])) : '';
	$nickname = isset($_POST['nickname']) ? addslashes(trim($_POST['nickname'])) : '';
	$website = isset($_POST['website']) ? addslashes(trim($_POST['website'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	$newpass = isset($_POST['newpass']) ? addslashes(trim($_POST['newpass'])) : '';
	$repeatpass = isset($_POST['repeatpass']) ? addslashes(trim($_POST['repeatpass'])) : '';

	if (strlen($nickname) > 20) {
		echo jsonEncode(array("code"=>-1,"msg"=>"昵称不能太长"));exit;
	} elseif (strlen($newpass)>0 && strlen($newpass) < 6) {
		echo jsonEncode(array("code"=>-3,"msg"=>"密码长度不得小于6位"));exit;
	} elseif (!empty($newpass) && $newpass != $repeatpass) {
		echo jsonEncode(array("code"=>-4,"msg"=>"两次输入的密码不一致"));exit;
	} elseif($User_Model->isNicknameExist($nickname, UID)) {
		echo jsonEncode(array("code"=>-5,"msg"=>"该昵称已存在"));exit;
    }
	$imgcode = Option::get("login_code")&&isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';
	$sessionCode=isset($_SESSION["code"])?$_SESSION["code"]:"";
	if(Option::get("login_code")=="y"&&(empty($imgcode)||$imgcode!=$sessionCode)){
		echo jsonEncode(array("code"=>-8,"msg"=>"验证码错误"));exit;
	}
	if($NullTwoOption["user_reg_mail_switch"]=="y"){
		$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
		$emailcode = isset($_POST['emailcode']) ? addslashes(trim($_POST['emailcode'])) : '';
		if ($email != '' && !checkMail($email)) {
			echo jsonEncode(array("code"=>-2,"msg"=>"电子邮件格式错误"));exit;
		}
		$row = $User_Model->getOneUser(UID);
		$blogname=Option::get("blogname");
		if($email!=$row["email"]){
			$existEmail = $db->once_fetch_array("SELECT uid FROM ".DB_PREFIX."user WHERE email='$email' AND uid!=".UID);
			if(!$emailcode||!isset($_SESSION[$blogname."code"])||!isset($_SESSION["new".$blogname])){
				echo jsonEncode(array("code"=>-5,"msg"=>"请先填写邮箱验证码"));exit;
			}else if(!isset($_SESSION[$blogname."code"])||strcasecmp($_SESSION[$blogname."code"],$emailcode)!=0){
				echo jsonEncode(array("code"=>-6,"msg"=>"邮箱验证码不正确"));exit;
			}else if($email!=$_SESSION["new".$blogname]){
				echo jsonEncode(array("code"=>-7,"msg"=>"填写邮箱和发送验证码的邮箱不一致"));exit;
			}else if(count($existEmail)>0){
				echo jsonEncode(array("code"=>-8,"msg"=>"邮箱已存在"));exit;
			}else{
				$_SESSION[$blogname."code"]=mt_rand(100000,999999);
			}
		}
	}
	if (!empty($newpass)) {
        $PHPASS = new PasswordHash(8, true);
		$newpass = $PHPASS->HashPassword($newpass);
		$User_Model->updateUser(array('password'=>$newpass), UID);
	}

	$photo_type = array('gif', 'jpg', 'jpeg','png');
	$usericon = $photo;
	if ($_FILES['avatar']['size'] > 0) {
		$file_info = uploadImages($_FILES['avatar']['name'], $_FILES['avatar']['error'], $_FILES['avatar']['tmp_name'], $_FILES['avatar']['size'], $photo_type, true);
		if (!empty($file_info['file_path'])) {
			$usericon = !empty($file_info['thum_file']) ? $file_info['thum_file'] : $file_info['file_path'];
		}
	}
	$updateData=array('nickname'=>$nickname, 'photo'=>$usericon, 'description'=>$description);
	if($NullTwoOption["user_reg_mail_switch"]=="y"){
		$updateData["email"]=$email;
	}
	if(Option::EMLOG_VERSION>="6.0.1"){
		$updateData["website"]=$website;
	}
	$User_Model->updateUser($updateData, UID);
	$CACHE->updateCache('user');
	
	//删除过期头像
	$photo_path = EMLOG_ROOT."/content/".$photo;
	if ($_FILES['avatar']['size'] > 0&&file_exists($photo_path)) {
		$photo_2 = str_replace('thum-', '', $photo_path);
		if ($photo_2 != $photo_path && file_exists($photo_2)) {
			@unlink($photo_2);
		}
		$photo_3 = preg_replace("/^(.*)\/(.*)$/", "\$1/thum52-\$2", $photo_2);
		if ($photo_3 != $photo_2 && file_exists($photo_3)) {
			@unlink($photo_3);
		}
		@unlink($photo_path);
	}
	$_SESSION["code"]="";
	$_SESSION[Option::get("blogname")."code"]="";
	$_SESSION["new".Option::get("blogname")]="";
	echo jsonEncode(array("code"=>0,"msg"=>"修改资料成功","url"=>BLOG_URL."?user&action=info"));
	exit;
}else if($action=="login"){
	$db = Database::getInstance();
	$username = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$imgcode = Option::get("login_code")&&isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';
	$ispersis = isset($_POST['ispersis']) ? addslashes(trim($_POST['ispersis'])) : '';
	
	$flag=false;
	if($username==""||$password==""){
		echo jsonEncode(array("code"=>-1,"msg"=>"请输入用户名、密码"));exit;
	}
	$sessionCode=isset($_SESSION["code"])?$_SESSION["code"]:"";
	if(Option::get("login_code")=="y"&&(empty($imgcode)||$imgcode!=$sessionCode)){
		echo jsonEncode(array("code"=>-2,"msg"=>"验证码错误"));exit;
	}
	$userData = $db->once_fetch_array("SELECT * FROM " . DB_PREFIX . "user WHERE username = '".$username."'");
	if($userData){
		$hash=$userData["password"];
		if(true===LoginAuth::checkPassword($password,$hash)){
			if(Option::EMLOG_VERSION>="6.1.1"){
				$authCode=md5(time());
				$db->query("UPDATE ".DB_PREFIX."user SET authCode='".$authCode."',logintime='".date("Y-m-d H:i:s",time())."' WHERE username='".$username."'");
				$_SESSION["__emlog_authCode"]=$authCode;
			}
			$loginname=$userData["username"];
			$flag=true;
		}
	}
	if($flag){
		LoginAuth::setAuthCookie($loginname,$ispersis);
		$_SESSION["code"]=null;
		echo jsonEncode(array("code"=>0,"msg"=>"登陆成功","url"=>BLOG_URL."?user"));exit;
	}else{
		echo jsonEncode(array("code"=>-3,"msg"=>"登陆失败，请检查是否填写正确"));exit;
	}
	exit;
}else if($action=="reg"){
	$db = Database::getInstance();
	$username = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$nickname = isset($_POST['nickname']) ? addslashes(trim($_POST['nickname'])) : '';
	$repass = isset($_POST['repass']) ? addslashes(trim($_POST['repass'])) : '';
	$imgcode = Option::get("login_code")&&isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';
	$mailcode = isset($_POST['mailcode']) ? addslashes(trim($_POST['mailcode'])) : '';
	
	if($NullTwoOption["user_reg_switch"]!="y"){
		echo jsonEncode(array("code"=>-1,"msg"=>"网站已关闭用户注册"));exit;
	}
	if($NullTwoOption["user_reg_mail_switch"]=="y"){
		if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$username)){
			echo jsonEncode(array("code"=>-2,"msg"=>"邮箱格式不正确"));exit;
		}
		
		if(!isset($_SESSION[Option::get("blogname")."code"])||strcasecmp($_SESSION[Option::get("blogname").'code'],$mailcode)!=0){
			echo jsonEncode(array("code"=>-3,"msg"=>"邮箱验证码错误"));exit;
		}
		if ($username!=$_SESSION["new".Option::get("blogname")]) {
			echo jsonEncode(array("code"=>-4,"msg"=>"填写邮箱和发送验证码的邮箱不一致"));exit;
			exit;
		}
	}else{
		if((strlen($username)>=0&&strlen($username)<4)||strlen($username)>18){
			echo jsonEncode(array("code"=>-5,"msg"=>"请输入4-18位的用户名"));exit;
		}
	}
	if((strlen($password)>=0&&strlen($password)<6)||strlen($password)>16){
		echo jsonEncode(array("code"=>-6,"msg"=>"请输入6-16位的密码"));exit;
	}
	if($password!==$repass){
		echo jsonEncode(array("code"=>-7,"msg"=>"两次输入密码不一致"));exit;
	}
	$sessionCode=isset($_SESSION["code"])?$_SESSION["code"]:"";
	if(Option::get("login_code")=="y"&&(empty($imgcode)||$imgcode!=$sessionCode)){
		echo jsonEncode(array("code"=>-8,"msg"=>"验证码错误"));exit;
	}
	
	$data = $db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "user WHERE username = '".$username."'");
	if($data["total"]>0){
		echo jsonEncode(array("code"=>-9,"msg"=>"用户名已注册"));exit;
	}
	$data = $db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "user WHERE nickname = '".$nickname."' AND nickname!=''");
	if($data["total"]>0){
		echo jsonEncode(array("code"=>-10,"msg"=>"昵称已注册"));exit;
	}
	
	$hasher=new PasswordHash(8,true);
	$password=$hasher->HashPassword($password);
	$userData=array(
		"username"=>$username,
		"password"=>$password,
		"nickname"=>$nickname,
		"role"=>"writer",
		"ischeck"=>"y"
	);
	$kItem = array();
	$dItem = array();
	foreach ($userData as $key => $data) {
		$kItem[] = $key;
		$dItem[] = $data;
	}
	$field = implode(',', $kItem);
	$values = "'" . implode("','", $dItem) . "'";
	$db->query("INSERT INTO " . DB_PREFIX . "user ($field) VALUES ($values)");
	$insert_id = $db->insert_id();
	if($insert_id){
		if(Option::EMLOG_VERSION>="6.1.1"){
			$authCode=md5(time());
			$db->query("UPDATE ".DB_PREFIX."user SET authCode='".$authCode."',logintime='".date("Y-m-d H:i:s",time())."' WHERE username='".$username."'");
			$_SESSION["__emlog_authCode"]=$authCode;
		}
		$CACHE->updateCache();
		LoginAuth::setAuthCookie($username);
		$_SESSION["code"]="";
		$_SESSION[Option::get("blogname")."code"]="";
		$_SESSION["new".Option::get("blogname")]="";
		echo jsonEncode(array("code"=>0,"msg"=>"注册成功","url"=>BLOG_URL."?user"));exit;
	}else{
		echo jsonEncode(array("code"=>-11,"msg"=>"注册失败，请检查是否填写正确"));exit;
		
	}
	exit;
}else if($action=="sendMailCode"){
	$username = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$imgcode = Option::get("login_code")&&isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';
	$blogname=Option::get("blogname");
	
	$sessionCode=isset($_SESSION["code"])?$_SESSION["code"]:"";
	if(Option::get("login_code")=="y"&&(empty($imgcode)||$imgcode!=$sessionCode)){
		echo jsonEncode(array("code"=>-1,"msg"=>"图片验证码错误"));exit;
	}
	if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$username)){
		echo jsonEncode(array("code"=>-2,"msg"=>"邮箱格式不正确"));exit;
	}
	if(!MAIL_SMTP||!MAIL_PORT||!MAIL_SENDEMAIL||!MAIL_PASSWORD){
		echo jsonEncode(array("code"=>-3,"msg"=>"请先配置邮箱参数"));exit;
	}
	$_SESSION[$blogname."code"]=mt_rand(100000,999999);
	if(sendmail_do(MAIL_SMTP, MAIL_PORT, MAIL_SENDEMAIL, MAIL_PASSWORD, $username, '【'.$blogname.'】验证码', '欢迎使用'.$blogname.'验证码服务，您的验证码是：'.$_SESSION[$blogname.'code'],$blogname)){
		$_SESSION["new".$blogname]=$username;
		echo jsonEncode(array("code"=>0,"msg"=>"获取邮箱验证码成功，注意查收！"));exit;
	}else{
		echo jsonEncode(array("code"=>-4,"msg"=>"获取邮箱验证码失败"));exit;
	}
	exit;
}
function jsonEncode($arr){
	foreach ( $arr as $key => $value ) {  
		$arr[$key] = urlencode ( $value );  
	}  
	$json=json_encode($arr);
	return urldecode($json);
}
?>