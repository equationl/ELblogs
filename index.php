<?php
@include_once('config.php');
@include_once('include/login_function.php');
@include_once('include/mysql_function.php');

//链接数据库
$con = connectMysql();
//列出总pv和访问首页pv
$c = mysql_fetch_array(mysql_query("SELECT visitHomePv FROM statistics"));
$visitHomePv = $c[0];
mysql_fetch_array(mysql_query("SELECT visitPv FROM statistics"));
$visitPv = $c[0];

//将数据分别+1
mysql_query("UPDATE statistics SET visitHomePv = $visitHomePv+1 WHERE visitHomePv = $visitHomePv");
mysql_query("UPDATE statistics SET visitPv = $visitPv+1 WHERE visitPv = $visitPv");


//读取最新(主要内容)
//短文
$array_shortTextNew = Array(
'context' => Array(),
'ID' => Array()
);
$i = 0;
$result = mysql_query("SELECT * FROM shortText ORDER BY ID DESC LIMIT 10");
while ($row_shortText = mysql_fetch_array($result)) 
{
   $array_shortTextNew['context'][$i] = get_dedata($row_shortText['context']);
   $array_shortTextNew['ID'][$i] = $row_shortText['ID'];
   $i++;
};
mysql_free_result($result);

//日志
$array_longTextNew = Array(
'tittle' => Array(),
'ID' => Array()
);
$i = 0;
$result = mysql_query("SELECT * FROM `longText` ORDER BY ID DESC LIMIT 10");
while ($row_longText = mysql_fetch_array($result))
{
   $array_longTextNew['tittle'][$i] = get_dedata($row_longText['tittle']);
   $array_longTextNew['ID'][$i] = $row_longText['ID'];
   $i++;
};
mysql_free_result($result);


//下载
$array_downloadNew = Array(
'name' => Array(),
'ID' => Array()
);
$i = 0;
$result = mysql_query("SELECT * FROM download ORDER BY ID DESC LIMIT 10");
while ($row_download = mysql_fetch_array($result))
{
   $array_downloadNew['name'][$i] = $row_download['name'];
   $array_downloadNew['ID'][$i] = $row_download['ID'];
   $i++;
};
mysql_free_result($result);


//获得更新(推荐)

$c = mysql_fetch_array(mysql_query("SELECT dateTime FROM download ORDER BY dateTime DESC LIMIT 1"));
$newest_d = $c[0];
$c = mysql_fetch_array(mysql_query("SELECT dateTime FROM shortText ORDER BY dateTime DESC LIMIT 1"));
$newest_s = $c[0];
$c = mysql_fetch_array(mysql_query("SELECT dateTime FROM `longText` ORDER BY dateTime DESC LIMIT 1"));
$newest_l = $c[0];

$id = mysql_fetch_array(mysql_query("SELECT ID FROM download WHERE dateTime = '$newest_d'"));
$name = mysql_fetch_array(mysql_query("SELECT name FROM download WHERE dateTime = '$newest_d'"));

$id_s = mysql_fetch_array(mysql_query("SELECT ID FROM shortText WHERE dateTime = '$newest_s'"));
$name_s = mysql_fetch_array(mysql_query("SELECT context FROM shortText WHERE dateTime = '$newest_s'"));
$id_l = mysql_fetch_array(mysql_query("SELECT ID FROM `longText` WHERE dateTime = '$newest_l'"));
$name_l = mysql_fetch_array(mysql_query("SELECT tittle FROM `longText` WHERE dateTime = '$newest_l'"));

$array_new = array(
array(//下载
'time' => strtotime($newest_d),
'id' => $id[0],
'file' => 'download',
'name' => $name[0]),
//短文
array(
'time' => strtotime($newest_s),
'id' => $id_s[0],
'file' => 'shorttext',
'name' => get_dedata($name_s[0])),
//日志
array(
'time' => strtotime($newest_l),
'id' => $id_l[0],
'file' => 'longtext',
'name' => get_dedata($name_l[0]))
);

$array_cache = array($array_new[0]['time'], $array_new[1]['time'], $array_new[2]['time']);
rsort($array_cache);
$theNewest = $array_cache[0];
foreach($array_new as $value){ 
   if (in_array($theNewest,$value)) 
   {
      $newest = $value;
   }
} 


//获得最热(推荐)
$c = mysql_fetch_array(mysql_query("SELECT visitor FROM download ORDER BY visitor DESC LIMIT 1"));
$hottest_d = $c[0];
$c = mysql_fetch_array(mysql_query("SELECT visitor FROM shortText ORDER BY visitor DESC LIMIT 1"));
$hottest_s = $c[0];
$c = mysql_fetch_array(mysql_query("SELECT visitor FROM `longText` ORDER BY visitor DESC LIMIT 1"));
$hottest_l = $c[0];

$id_d = mysql_fetch_array(mysql_query("SELECT ID FROM download WHERE dateTime = '$newest_d'"));
$name_d = mysql_fetch_array(mysql_query("SELECT name FROM download WHERE dateTime = '$newest_d'"));
$id_s = mysql_fetch_array(mysql_query("SELECT ID FROM shortText WHERE dateTime = '$newest_s'"));
$name_s = mysql_fetch_array(mysql_query("SELECT context FROM shortText WHERE dateTime = '$newest_s'"));
$id_l = mysql_fetch_array(mysql_query("SELECT ID FROM `longText` WHERE dateTime = '$newest_l'"));
$name_l = mysql_fetch_array(mysql_query("SELECT tittle FROM `longText` WHERE dateTime = '$newest_l'"));
$array_hot = array(
array(//下载
'visitor' => $hottest_d,
'id' => $id_d[0],
'file' => 'download',
'name' => $name_d[0]),
//短文
array(
'visitor' => $hottest_s,
'id' => $id_s[0],
'file' => 'shorttext',
'name' => get_dedata($name_s[0])),
//日志
array(
'visitor' => $hottest_l,
'id' => $id_l[0],
'file' => 'longtext',
'name' => get_dedata($name_l[0]))
);

$array_cache = array($array_hot[0]['visitor'], $array_hot[1]['visitor'], $array_hot[2]['visitor']);
rsort($array_cache);
$theHottest = $array_cache[0];
foreach($array_hot as $value){ 
   if (in_array($theHottest,$value)) 
   {
      $hottest = $value;
   }
} 
?>


	<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
	<meta name="MobileOptimized" content="320">
	<meta name="author" content="equationl">
	<meta name="copyright" content="Copyright (c) 2014 equationl.">
	<meta name="description" content="equationl's blogs">
	<title>equationl's blogs</title>
	
	 <link rel="stylesheet" type="text/css" href="./css/index.css" />
	 <script src="js/sidebar.js" type="text/javascript"></script>
	    
		    </head>
		    <body>
		    
		    <!--侧边栏内容-->
		    <div class="menu_bg" id="context">
		    <?php
		       if (isLogin() != 1) {
		          //未登陆
		          echo ' <a href="login.php">登陆</a>
		    <a href="login.php?do=register">注册</a>
		    <br />
';
		       }
		       else {
		          //已登陆
		          $userinformation = getUser($_SESSION["id"]);
		          echo '你好，'.$userinformation["username"].'
		          <br />
		          <a href="login.php?do=logout">注销</a>';
		          //如果是管理员
		          if ($userinformation["group"] == 0) {
		             echo '<br /><a href="admin/">管理</a>';
		          }
		       }
		    ?>
		    <div class="line"></div>
		    <a href="/bbq">·表白墙<a><br /> <br />
		    <a href="">·待定<a><br /> <br />
		    <a href="">·待定<a><br /> <br />
		    </div>


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
		    
		    <!--diy内容-->
		    <?php
		    $result = mysql_query("SELECT * FROM `diyHome`");
	     while ($row = mysql_fetch_array($result)) 
	     {
	        echo get_dedata($row['context']).'<br />';
	     }
	     mysql_free_result($result);
		    ?>
		    
		    
		    <!--相关推送-->
		    <div class="tittletext_yellow">更新:</div>
		    <?php
		    echo '<a href="'.$newest['file'].'.php?id='.$newest['id'].'">'.$newest['name'].'</a>';
		    ?>
		    <br /><br />
		    <div class="tittletext_red">热门:</div>
		    <?php
		    echo '<a href="'.$hottest['file'].'.php?id='.$hottest['id'].'">'.$hottest['name'].'</a>';
		    ?>
		    
		    <!--内容-->
		    <br /><br />
		    
		    <!--侧边栏-->
		    <div class="menu" onclick="switchSysBar()" id="switchPoint">
		    <img src="image/icon-navicon-round.svg" width="50" high="50"/> 
		    </div>
		    
		    
		    <div class="tittletext_white">
		    随录:
		    </div>
		    <font size="1px">随手录下那一瞬间的心情</font> <br />
		    <?php 
		    $num = count($array_shortTextNew['ID']);
		    for($i=0;$i<$num;$i++){ 
		    echo $i.'.<a href="shorttext.php?id='.$array_shortTextNew['ID'][$i].'">'.get_dedata($array_shortTextNew['context'][$i]).'</a><br />';
		    } 
		    ?>
		    
		    <div class="shorttext"><a href="shorttext.php">查看更多....</a></div>
		    
		    <br /><br />
		    <div class="tittletext_white">
		    日志:
		    </div>
		    <font size="1px">以文字记录历史的进程</font> <br />
		    <?php 
		    $num = count($array_longTextNew['ID']);
		    for($i=0;$i<$num;$i++){ 
		    echo $i.'.<a href="longtext.php?id='.$array_longTextNew['ID'][$i].'">'.get_dedata($array_longTextNew['tittle'][$i]).'</a><br />';
		    } 
		    ?>
		    <div class="shorttext"><a href="longtext.php">查看更多....</a></div>

 <br /><br />
		    <div class="tittletext_white">
		    下载:
		    </div>
		    <font size="1px">我的产品下载大全</font> <br />
		    <?php 
		    $num = count($array_downloadNew['ID']);
		    for($i=0;$i<$num;$i++){ 
		    echo $i.'.<a href="download.php?id='.$array_downloadNew['ID'][$i].'">'.$array_downloadNew['name'][$i].'</a><br />';
		    } 
		    ?>
		    <div class="shorttext"><a href="download.php">查看更多....</a></div>
		    		    
		    <div class="endtext">
		    © 2014 Equationl.Com All Rights Reserved.
		    </div>
		    </body>
		    </html>
