<?php
@include_once('config.php');
@include_once('include/login_function.php');
@include_once('include/mysql_function.php');

//链接数据库
$con = connectMysql();
//列出总pv和访问首页pv
$c = mysql_fetch_array(mysql_query("SELECT visitLongTextPv FROM statistics"));
$visitLongTextPv = $c[0];
$c = mysql_fetch_array(mysql_query("SELECT visitPv FROM statistics"));
$visitPv = $c[0];

//将数据分别+1
mysql_query("UPDATE statistics SET visitLongTextPv = $visitLongTextPv+1 WHERE visitLongTextPv = $visitLongTextPv");
mysql_query("UPDATE statistics SET visitPv = $visitPv+1 WHERE visitPv = $visitPv");

//如果指定了id，获取结果集(为了标题)
if (!empty($_GET["id"]))
{
   $result = mysql_query("SELECT * FROM `longText` WHERE ID ='".$_GET["id"]."'");
   $row_long = mysql_fetch_array($result);
}

?>


	<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
	<meta name="MobileOptimized" content="320">
	<meta name="author" content="equationl">
	<meta name="copyright" content="Copyright (c) 2014 equationl.">
	<title><?php 
	if (!empty($_GET["id"]))
  {  	echo get_dedata($row_long["tittle"]); }
  else{echo '日志';} ?></title>
	
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
	   $result = mysql_query("SELECT * FROM `longText`");
	   while ($row = mysql_fetch_array($result)) 
	   {
     echo '<div class="longtext"><a href="longtext.php?id='.$row["ID"].'">'.get_dedata($row["tittle"]).'</a><div class="line"></div>'.$row["dateTime"].'
       </div> <br />';
     }
     mysql_free_result($result);
  }
  else
  {
     //指定id，直接进入内容浏览
	   echo '<br />'.get_dedata($row_long["tittle"]).'<div class="longtext">'.get_dedata($row_long["context"]).'<div class="line"></div>'.$row_long["dateTime"].'-'.$row_long["group"].'<div class="bigline"></div><a href="reply.php?id='.$row_long["ID"].'&for=longtext">回复:</a><br />';
	   //取出评论相关内容
	   $result = mysql_query("SELECT * FROM comment WHERE relatedId = '".$_GET["id"]."' AND `for` = 'longText'");
	   $i = 0;
	   while ($row = mysql_fetch_array($result) )
	   {
	      echo $i.'.'.$row["context"].'--'.$row["userName"].'('.$row["userId"].')'.'·'.$row["dateTime"].'<br /><br />';
	      $i++;
	   }
	   echo '</div><br />';
	   //浏览数+1
	   $visitor = $row_long['visitor'];
	   $rowid = $_GET['id'];
	   mysql_query("UPDATE `longText` SET visitor = $visitor+1 WHERE id=$rowid");

	   
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
