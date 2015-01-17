<?php
@include_once('encrypt.php');
/*
加密用户登陆时的信息 (用户名，密码)
加密后存于 cookie
参数说明:
	$text 欲加密文本
	$operation 加密(E)or解密(D)

*/
function encrypt_login($text, $operation) {
	//$text为空时
	if (empty($text)) {return "";}
	
	if ($operation == "E") {
		return encrypt_string("$text",'E',ENCRYPTKEY);
	}
	
	else {
		return encrypt_string("$text",'D',ENCRYPTKEY);
	}		
}

/*
*提交内容过滤
*/
function filter_post($str) {
	//先把空格和换行等保留下来
	$str = html_replace($str);
	//去掉html标签
	$str = filters_all($str);
	//去除sql关键字
	$str = sql_encode($str);
	
	return $str;
}


?>