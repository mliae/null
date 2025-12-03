<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}

$action = isset($_POST['action']) ? addslashes(trim($_POST['action'])) : '';
if($action=="ajax_content_post"){
	include_once "module/log_preview.php";
	exit;
}else if($action=="ajax_mlike_add"){
	if(!isset($_COOKIE["like_count_flag"])){
		$NullTwoOption["like_count"]=$NullTwoOption["like_count"]+1;
		$result=$db->query("UPDATE `".DB_PREFIX."options` SET `option_value`='".addslashes(serialize($NullTwoOption))."' WHERE `option_name`='theme:NullTwo'",true);
		if($result){
			$CACHE->updateCache(array("options","logalias"));
			setcookie('like_count_flag', 'true', time() + 31536000);
			echo '{"success":"ok","like":'.$NullTwoOption["like_count"].'}';
		}
	}
	exit;
}
?>