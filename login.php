	<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
	<meta name="MobileOptimized" content="320">
	<meta name="author" content="equationl">
	<meta name="copyright" content="Copyright (c) 2014 equationl.">
	<title>登陆</title>
	
	 <link rel="stylesheet" type="text/css" href="./css/index.css" />
	    
		    </head>
		    <body>

<?php
@include_once('config.php');
@include_once('include/login_function.php');
@include_once('include/mysql_function.php');


function unsetdata()
{
   //销毁session及cookie
   unset($_SESSION['id']);
   unset($_SESSION['pw']);
   session_destroy();
   setcookie("id", '', time()-42000);
   setcookie('pw', '', time()-42000);
}

//链接数据库
$con = connectMysql();

//验证cookie
$localcookie_id = login_getCookie("id") ;
$localcookie_pw = login_getCookie("pw") ;
if (!empty($localcookie_id) and !empty($localcookie_pw) and !empty($_GET['do']))
{
   //cookie存在
   if (empty($_SESSION["id"]) or empty($_SESSION["pw"]) ) {
      //cookie存在但session不存在
      echo '非法的登陆！请尝试 <a href="login.php?do=logout">注销</a> 后重试。';
   }
   if ($_GET['do'] == 'logout')
   {
      //注销
      unsetdata();
      echo '已注销，点击 <input type="button" name="Submit" onclick="javascript:history.back(-1);" value="返回上一页"> ';
      exit;

   }
   if ($_SESSION["id"] == $localcookie_id && $_SESSION["pw"] == $localcookie_pw)
   {
      //已登陆，验证通过
      echo '已经登陆，不需要再重复登陆了咯，点击 <input type="button" name="Submit" onclick="javascript:history.back(-1);" value="返回上一页"> ';
      exit;
   }
   
   else
   {
      //验证错误，销毁保存的session和cookie
      echo '验证失败!';
      unsetdata();
      exit();
   }
      
}


//已get
if (!empty($_GET["do"]))
{
   if ($_GET["do"] == "register")
   {
      //注册
      //修改标题
      echo '<script>
document.title=\'注册\';

</script>';
      echo '暂不开放注册, <input type="button" name="Submit" onclick="javascript:history.back(-1);" value="返回上一页"> ';
      exit;
   }
   else if($_GET["do"] == "login")
   {
      //登陆
     
      if (!empty($_POST["name"]) and !empty($_POST["password"]) )
      {
         //已post
         if ( $c = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE username = '". $_POST["name"]."' AND password = '". $_POST["password"]."' limit 1")) )
         {
            //登陆成功
            $id = $c['ID'];
            $pw = $c['password'];
            $_SESSION['id'] = $id;
            $_SESSION['pw'] = $pw;
            setcookie("id", encrypt_login("$id", "E"), time()+30*24*60*60);
            setcookie("pw", encrypt_login("$pw", "E"), time()+30*24*60*60);
            echo '登陆成功！<br />欢迎'.$c["username"].'， <input type="button" onclick="javascript:history.back(-1);" value="返回上一页">  <input type="button" onclick="javascript:window.location = \'index.php\';" value="返回首页"> ';
            exit;
         }
         else
         {
            //登陆失败
            exit('用户名或密码错误！点击 <input type="button" onclick="javascript:history.back(-1);" value="返回"> 重试');
         }
      }
   }
}

//未get or 未post
echo '<form action="login.php?do=login" method="post">
  用户名: <input type="text" name="name" /> <br />
  密码: <input type="password" name="password" /> <br />
  <input type="submit" value="登陆" />
</form>
  <a href="login.php?do=register">注册</a>
  <a href="login.php?do=logout">   注销</a>
  <br />
  <input type="button" onclick="javascript:history.back(-1);" value="返回上一页">
  <br />
  <input type="button" onclick="javascript:window.location = \'index.php\';" value="返回首页"> ';

?>

</body>
</html>