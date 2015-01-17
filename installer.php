<?php
if(!empty($_POST["name"])) 
{
      $write = '<?php'."\n\n"
      .'$dbhost = '."'".$_POST["host"]."';\n"
      .'$dbuser = '."'".$_POST["username"]."';\n"
      .'$dbpassword = '."'".$_POST["password"]."';\n"
      .'$dbname = '."'".$_POST["name"]."';\n"
      .'?>';
      $file=fopen("config.php","w");
      fwrite($file,$write);
      fclose($file);
      
      $con = mysql_connect($_POST["host"], $_POST["username"], $_POST["password"] );
      if (!$con)
      {
         $file=fopen("config.php","w");
         fwrite($file,'');
         fclose($file);
         die('Could not connect: ' .mysql_error());
         }
      else 
      {
       mysql_set_charset("latin1"); mysql_select_db($_POST["name"], $con);
        //统计表
        $sql = "CREATE TABLE statistics(visitPv int,
         visitHomePv int,
         visitDowloadPv int,
         visitOthersPv int,
         visitShortTextPv int,
         visitLongTextPv int
        )";
        mysql_query($sql,$con);
        mysql_query("INSERT INTO statistics (visitPv,
         visitHomePv,
         visitDowloadPv,
         visitOthersPv,
         visitShortTextPv,
         visitLongTextPv) VALUES (5,1,1,1,1,1)",$con);

        //用户信息
        mysql_query("CREATE TABLE user(ID int NOT NULL AUTO_INCREMENT, 
        PRIMARY KEY(ID),
        username varchar(20),
        password varchar(12),
        `group` int,
        greateDate datetime
        )",$con);
         mysql_query("INSERT INTO user (username,
        password,
        `group`,
        greateDate) VALUES ('equationl','548326424364',0,'".date('Y-m-d H:i:s',time())."')",$con);
        //短文
        mysql_query("CREATE TABLE shortText(ID int NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(ID),
        context tinytext,
         dateTime datetime,
         `group` tinytext,
         visitor int
        )",$con);
        mysql_query("INSERT INTO shortText (context,
         dateTime,
         `group`,
         visitor) VALUES ('测试随录，来自系统的测试消息','".date('Y-m-d H:i:s',time())."','默认',1)",$con);
        //长文
        mysql_query("CREATE TABLE `longText`(ID int NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(ID),
         context longtext,
         dateTime datetime,
         `group` tinytext,
         tittle tinytext,
         visitor int
        )",$con);
        mysql_query("INSERT INTO `longText` (context,
         dateTime,
         `group`,
         tittle,
         visitor
) VALUES ('测试日志，进度:1.日志(完成)2.随录(完成)3.下载(未完成)4.回复(未完成)5.首页(完成)6.登陆(未完成)7.后台(未完成)，总完成42.9％，迫于压力，暂停开发，重启时间待定--equationl','".date('Y-m-d H:i:s',time())."','默认','测试日志',1)",$con);
        //评论
        mysql_query("CREATE TABLE comment(relatedId int,
         `for` tinytext,
         context mediumtext,
         dateTime datetime,
         userName tinytext,
         userId int
        )",$con);
        mysql_query("INSERT INTO comment (relatedId,
         `for`,
         context,
         dateTime,
         userName,
         userId
) VALUES (1,'shortText','测试回复','".date('Y-m-d H:i:s',time())."','equationl',1)",$con);
        //下载文件信息
        mysql_query("CREATE TABLE download(ID int NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(ID),
        name tinytext,
        context longtext,
        changeLog mediumtext,
        url mediumtext,
        dateTime datetime,
        visitor int
        )",$con);
        mysql_query("INSERT INTO download (name,
        context,
        changeLog,
        url,
        dateTime,
        visitor
) VALUES ('测试下载','点击可下载logo','无','image/logo.png','".date('Y-m-d H:i:s',time())."',1)",$con);
              
        mysql_close($con);

      
         echo 'finish!';
         exit;
      }

}
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=2.0"/>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<head>
<title>安装</title>
</head>
<body>
<!--<link href="style/index.css" rel="stylesheet" type="text/css"> -->
<form action="installer.php" method="post">
  数据库地址: <input type="text" name="host" /> <br />
  数据库用户名: <input type="text" name="username" /> <br />
  密码: <input type="text" name="password" /> <br />
  数据库名: <input type="text" name="name" /> <br />
  <input type="submit" value="确定" />
</form>

</body>
</html>
