	<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
	<meta name="MobileOptimized" content="320">
	<meta name="author" content="equationl">
	<meta name="copyright" content="Copyright (c) 2014 equationl.">
	<title>管理界面</title>
	
	 <link rel="stylesheet" type="text/css" href="../css/index.css" />
	    
		    </head>
		    <body>


<?php
@include_once('../config.php');
@include_once('../include/mysql_function.php');
@include_once('../include/login_function.php');
//链接数据库
$con = connectMysql();

	
//用于检测是否属于某个提交
function check_get() {
   //get不为空
   if (!empty($_GET["do"])) {
      $get_do = $_GET["do"];
      
      if ($get_do == 'writeShortText')
         {
         //提交随录内容
         $result = mysql_query("SELECT `name` FROM `object_group` WHERE `for`='shortText'");
         echo '<form action="post.php" method="post">
         分类: <select name="group">';
	   while ($row = mysql_fetch_array($result) )
	   {
	      echo '<option value="'.$row['name'].'">'.$row['name'].'</option>' ;
	   }
    echo '</select> <br />
  内容: <textarea rows="10" cols="30" name="context"> </textarea><br />
  日期: <input type="text" name="date" value="'.date('Y-m-d H:i:s',time()).'"/> 
  <input type="hidden" name="model" value="shortText" /><br />
  
  <input type="submit" value="提交" />
</form>';

         }
         
      else if ($get_do == 'writeLongText')
         {
         //提交日志内容
         echo '<form action="post.php" method="post">';
        $result = mysql_query("SELECT `name` FROM `object_group` WHERE `for`='longText'");
         echo '
         分类: <select name="group">';
	   while ($row = mysql_fetch_array($result) )
	   {
	      echo '<option value="'.$row['name'].'">'.$row['name'].'</option>' ;
	   }
    echo '</select> <br />
  标题: <input type="text" name="title"/> <br />
  内容: <textarea rows="10" cols="30" name="context"> </textarea><br />
  日期: <input type="text" name="date" value="'.date('Y-m-d H:i:s',time()).'"/> 
  <input type="hidden" name="model" value="longText" /><br />
  
  <input type="submit" value="提交" />
</form>';

         
         }
         
      else if ($get_do == 'writeDownload')
         {
         //提交下载内容
         echo '<form action="post.php" method="post">';
        $result = mysql_query("SELECT `name` FROM `object_group` WHERE `for`='download'");
         echo '
         分类: <select name="group">';
	   while ($row = mysql_fetch_array($result) )
	   {
	      echo '<option value="'.$row['name'].'">'.$row['name'].'</option>' ;
	   }
    echo '</select> <br />
  标题: <input type="text" name="title"/> <br />
  内容: <textarea rows="10" cols="30" name="context"> </textarea><br />
  更新内容: <textarea rows="10" cols="30" name="changeLog"> </textarea><br />
  地址: <input type="text" name="url"/> <br />
  日期: <input type="text" name="date" value="'.date('Y-m-d H:i:s',time()).'"/> 
  <input type="hidden" name="model" value="download" /><br />
  
  <input type="submit" value="提交" />
</form>';

         }
         
         else if ($get_do == 'writeDiyHome')
         {
         $row = mysql_fetch_array(mysql_query("SELECT context FROM diyHome"));
         //提交首页公告
         echo '<form action="post.php" method="post">';
    echo '<br />
  内容: <textarea rows="10" cols="30" name="context">'.$row[0].'</textarea><br />
  <input type="hidden" name="model" value="writeHP" /><br />
  
  <input type="submit" value="提交" />
</form>';
         }
         
      else if ($get_do == 'readPv')
         {
         //读取PV统计
         $pvInformation = mysql_fetch_array(mysql_query("SELECT * FROM statistics"));
         echo '访问总pv:'.$pvInformation['visitPv'].
         '<br />访问首页pv:'.$pvInformation['visitHomePv'].
         '<br />访问其他pv:'.$pvInformation['visitOthersPv'].
         '<br />访问短文pv:'.$pvInformation['visitShortTextPv'].
         '<br />访问日志pv:'.$pvInformation['visitLongTextPv'] ;
         }
     else if ($get_do == 'addGroup') {
      echo '<form action="post.php" method="post">
      <br />
  对象: <input type="text" name="for"> </textarea><br />
  名字: <input type="text" name="name"> </textarea><br />
  权重: <input type="text" name="permission"> </textarea><br />
  <input type="hidden" name="model" value="addGroup" /><br />
  
  <input type="submit" value="提交" />
</form>' ;
      }
   }
     
   
  else {
     //输出html内容
     echo '<a href=?do=writeShortText>新建短文</a><br /> 
     <a href=?do=writeLongText>新建日志</a><br />
     <a href=?do=writeDownload>新建下载</a><br />
     <a href=?do=writeDiyHome>修改首页公告</a><br />
     <a href=?do=readPv>查看pv</a><br />
     <a href=?do=addGroup>添加分组</a><br /> 
     <a href="../index.php">返回首页</a><br />';
  }
   
}
	
//检测是否登陆
if (isLogin()==1) {
   //已登陆
   //获取用户
   $user_information = getUser($_SESSION["id"]);
   if(checkGroup($user_information["group"]) == 0) {
      //用户组不对
      echo '没有权限进行此操作！';
      exit;
   }
   //权限等均正常
   echo '<font size=10>WELCOME,'.$user_information['username'].'!</font><br />';
   check_get();
}
//未登陆
else {echo isLogin();}
		 
?>

</body>
</html>