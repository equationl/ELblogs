<?php

@include_once('init_config.php');
@include_once('encrypt.php');


//设置时区
date_default_timezone_set(INITIALTIMEZONE);


/*
*过滤文本
*		$text:		欲过滤文本
*/
function get_endata($text) {
		if (empty($text)) {return "";}
		else {
			return filter_post($text);
		}
	}

/*
*获取还原(部分)后的数据
*/
function get_dedata($str) {
	return sql_decode($str);
}

/*
获取用户信息
id: 欲获取用户的id
成功获取返回一个包含用户信息的数组
否则输出错误信息
*/
function getUser($id) {
   $information = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE ID = '".$id."' limit 1"));
   return $information;
}

/*
获取统计信息
直接返回
*/
function getPv() {
   $information = mysql_fetch_array(mysql_query("SELECT * FROM statistics"));
   return $information;

}

/*
链接到数据库
注意，每个php的头都应该先调用该函数
返回 mysql $con
*/
function connectMysql() {
   //定义全局变量
   global $dbhost,$dbuser,$dbpassword,$dbname;
   
   session_start();
   //链接数据库
   $con = mysql_connect("$dbhost","$dbuser","$dbpassword");
   //链接失败
   if (!$con)
   {
     die('Could not connect: ' . mysql_error());
   }
   //设置编码
   mysql_set_charset("latin1");
//选择一个数据库
   mysql_select_db("$dbname", $con);
   
   return $con;
}
?>