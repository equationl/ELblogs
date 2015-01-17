<?php
@include_once('config.php');
@include_once('include/login_function.php');
@include_once('include/mysql_function.php');

//链接数据库
$con = connectMysql();
//列出总pv和访问首页pv
$c = mysql_fetch_array(mysql_query("SELECT visitShortTextPv FROM statistics"));
$visitShortTextPv = $c[0];
$c = mysql_fetch_array(mysql_query("SELECT visitPv FROM statistics"));
$visitPv = $c[0];

//将数据分别+1
mysql_query("UPDATE statistics SET visitShortTextPv = $visitShortTextPv+1 WHERE visitShortTextPv = $visitShortTextPv");
mysql_query("UPDATE statistics SET visitPv = $visitPv+1 WHERE visitPv = $visitPv");
//释放

?>


	<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
	<meta name="MobileOptimized" content="320">
	<meta name="author" content="equationl">
	<meta name="copyright" content="Copyright (c) 2014 equationl.">
	<title>心情随录</title>
	
	 <link rel="stylesheet" type="text/css" href="./css/index.css" />
	    
		    </head>
		    <body>
		    <!--顶部文字-->
		    <div class="toptext">
		      <img src="./image/logo.png" >
		      <br />
			    <div class="changebg">
		      <a href="index.php">首页</a>
			    </div>
			    <div class="changebg">
		      <a href="shorttext.php">随录</a>
			    </div>
			    <div class="changebg">
		      <a href="longtext.php">日志</a>
			    </div>
			    <div class="changebg">
		      <a href="download.php">下载</a>
			    </div>
			    <div class="changebg">
		      <a href="others/">更多...</a>
			    </div>
		    </div>
		    <br />
		    
	<?php	    
	//没有指定id
	if (empty($_GET['id'])) {
	   $result = mysql_query("SELECT * FROM shortText");
	   while ($row = mysql_fetch_array($result)) 
	   {
     echo '<div class="shorttext"><a href="shorttext.php?id='.$row["ID"].'">'.get_dedata($row["context"]).'</a><div class="line"></div>'.$row["dateTime"].'
       </div> <br />';
     }
     mysql_free_result($result);
  }
  else
  {
     //指定id，直接进入内容浏览
     $result = mysql_query("SELECT * FROM shortText WHERE ID ='".$_GET["id"]."'");
	   $row = mysql_fetch_array($result);
	   echo '<div class="shorttext">'.get_dedata($row["context"]).'<div class="line"></div>'.$row["dateTime"].'-'.$row["group"].'<div class="bigline"></div><a href="reply.php?id='.$row["ID"].'&for=shorttext">回复:</a><br />';
	   //取出评论相关内容
	   $result = mysql_query("SELECT * FROM comment WHERE relatedId = '".$_GET["id"]."' AND `for` = 'shortText'");
	   $i = 0;
	   while ($row_t = mysql_fetch_array($result) )
	   {
	      echo $i.'.'.$row_t["context"].'--'.$row_t["userName"].'('.$row_t["userId"].')'.'·'.$row_t["dateTime"].'<br /><br />';
	      $i++;
	   }
	   echo '</div><br />';
	   //浏览数+1
	   $visitor = $row['visitor'];
	   $rowid = $_GET['id'];
	   mysql_query("UPDATE `shortText` SET visitor = $visitor+1 WHERE id=$rowid");
	   //释放
	   mysql_free_result($result);
  }
?>

			   <br />
		    <div class="endtext">
		    © 2014 Equationl.Com All Rights Reserved.
		    </div>
		    </body>
		    </html>
