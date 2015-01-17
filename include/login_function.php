<?php

//包含安全过滤文件
@include_once("safety.php");
//@include_once("init_config.php");

/*获取cookie(解密后)
	$key cookie的key
	失败则返回空
*/
function login_getCookie($key) {
	if (empty($_COOKIE["$key"])) {
		return "";
	}
	return encrypt_login($_COOKIE["$key"], "D");
}


/*检测是否登陆
   已登陆则返回 1
   否则返回信息

*/
function isLogin() {
			$id_cookie = login_getCookie("id");
			$pw_cookie = login_getCookie("pw");
			if (!empty($id_cookie) and !empty($pw_cookie) and !empty($_SESSION["id"]) and !empty($_SESSION["pw"]) )
			{
			   //cookie存在
			   $localcookie_id = login_getCookie("id") ;
			   $localcookie_pw = login_getCookie("pw") ;
			
			   if ($_SESSION["id"] == $localcookie_id && $_SESSION["pw"] == $localcookie_pw)
			   {
			      //已登陆，验证通过
			      //echo 'welcome! '.$_SESSION["id"];
			      return 1;
			   }
			   
			   else
			   {
			      //验证错误
			      return '验证失败，请重新 <a href="../login.php">登陆 </a> !';
			      exit;
			   }
			      
			}
			
			else
			{
			   //没有登陆
			   return '请先 <a href="../login.php">登陆</a> !';
			   exit;
			}
		
		}

/*检测用户组
 groupid:欲检测目标id
    注意，调用本函数前必须先调用 isLogin() 函数检测是否已经登陆
    返回:
       正确返回 1
       否则返回 0
*/
function checkGroup($groupid) {
   //验证用户组
		$mysql_user = 	getUser($_SESSION["id"]);
		if ($mysql_user["group"] == $groupid) {
		//用户组正确
		return 1;
		//exit;
		}
		else {
		   return 0;
		}

}
?>