<?php
if (!empty($_GET["sure"])) {
   if ($_GET["sure"] != "0" ) {
      //更新开始 
      echo 'UPDATE,RUNNING.....';
      @include_once('include/init_function.php');
      //链接数据库
      $con = connectMysql();
      
      //新建表 object_group
      $sql = "CREATE TABLE object_group(
        ID int NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(ID),
        `for` tinytext,
        name tinytext,
        permission int
        )";
       mysql_query($sql,$con);
       
       //新建表 diyHome
      $sql = "CREATE TABLE diyHome(
        context longtext
        )";
       mysql_query($sql,$con);
       //添加默认数据
       mysql_query("INSERT INTO diyHome (context) VALUES ('默认公告')",$con);
       
       //在download添加字段group
       $sql = "ALTER TABLE download ADD COLUMN `group` tinytext";
       mysql_query($sql,$con);
       //添加默认数据
      /* mysql_query("INSERT INTO download (name,
        context,
        changeLog,
        url,
        dateTime,
        visitor,
        group
) VALUES ('测试下载','点击可下载logo','无','image/logo.png','".date('Y-m-d H:i:s',time())."',1,'默认')",$con); */
       
       
       
       echo 'ALL DONE.';

      exit;  
   }
}

echo 'UPDATE,SURE?<br />';
echo '<p><a href=updateer.php?sure=1>YES,I SURE</a><br />';
echo '<p><a href=index.php>NO,THANKS</a><br />';

?>