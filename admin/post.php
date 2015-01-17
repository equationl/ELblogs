<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
<meta name="MobileOptimized" content="320">
<meta name="author" content="equationl">
<meta name="copyright" content="Copyright (c) 2014 equationl.">
<meta name="description" content="equationl">
	<title>POST</title>
	
	 <link rel="stylesheet" type="text/css" href="../css/index.css" />
		    </head>
		    <body>



<?php
@include_once('../config.php');
@include_once('../include/mysql_function.php');
@include_once('../include/login_function.php');
//链接数据库
$con = connectMysql();


function save_data()
{
/*
**成功执行返回1
**否则返回0
*/
    global $con;
    if (!empty($_POST['model']))
    {
       //POST不为空
       if ($_POST['model'] == 'shortText')
       {
           //提交随录
           $context = get_endata($_POST["context"]);
           $sql = "INSERT INTO shortText (context, dateTime, `group` )
VALUES ('$context','$_POST[date]','$_POST[group]')";
           doSql($sql);
       }
       if ($_POST['model'] == 'longText')
       {
           //提交日志
           $context = get_endata($_POST["context"]);
           $title = get_endata($_POST["title"]);
           $sql = "INSERT INTO `longText` (context, `dateTime`, `group`, `tittle`) VALUES ('$context','$_POST[date]','$_POST[group]','$title')";
           doSql($sql);
       }
       if ($_POST['model'] == 'download')
       {
           //提交下载
           $context = get_endata($_POST["context"]);
           $title = get_endata($_POST["title"]);
           $changeLog = get_endata($_POST["changeLog"]);
           $sql = "INSERT INTO download (context, dateTime, `group` , changeLog, url, name)
VALUES ('$context','$_POST[date]','$_POST[group]','$changeLog','$_POST[url]','$title') ";
           doSql($sql);
       }
       if ($_POST['model'] == 'writeHP')
       {
           //更改首页
           $context = get_endata($_POST["context"]);
           $sql = "UPDATE diyHome SET context='$context'";
           mysql_query($sql,$con);
       }
       if ($_POST['model'] == 'addGroup') {
          //添加分组
          $name = get_endata($_POST["name"]);
          $for = get_endata($_POST["for"]);
           $sql = "INSERT INTO object_group (`for`, name, permission)
VALUES ('$for', '$name', '$_POST[permission]' )";
           doSql($sql);
       }
       
       
       
    }
    else 
    {
       echo '没有数据!';
       return 0;
    }
    return 1;
}

/*
执行sql
*/
function doSql($sql) {
  global $con;
  if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
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
   
   echo '<font size=15>欢迎进入后台</font><br />';
   if(save_data() != 0)
   {
      echo '执行成功<br />点击 <a href="index.php">返回</a>';
   }
   else
   {
      echo '执行失败';
   }
}
//未登陆
else {echo isLogin();}


?>
</body>
</html>